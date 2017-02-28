package print_web;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class HTTPConnection {
	String host = "http://zsofiesdavid.hu";
	String pass = "";
	Main main;
	
	public HTTPConnection(Main main, String url, String semmi, String pass2) {
		host = url;
		this.pass = pass2;
		this.main = main;
	}

	public void test() throws Exception {
		sendGet(true);
		
	}

	public int exec() {
		try {
			String resp = sendGet(false);
			if(resp.equals("NO_DATA")){
				return 0;
			}
			if(resp.equals("ERROR")){
				return 0;
			}
			if(resp.contains("#_#")){
				String[] data = resp.split("#_#");
				if(data.length == 6){
					int id = Integer.parseInt(data[0]);
					int amount = Integer.parseInt(data[1]);
					if(main.print(id,amount,data[2],data[3],data[4],data[5])){	        		
		        		main.log("print OK "+id);
		        		return 1;
		        	}else{	        		
		        		main.log("print Error "+id);
		        		return -1;
		        	}
				}else{
					main.log("print data Error "+data.toString());
					sendError(data.toString());
	        		return -1;
				}				
			}else{
				return 0;
			}			
			
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return 0;
	}
	
	private String sendGet(boolean test) throws Exception {

		String url = host+"/printer.php?pass="+pass;
		if(test){
			url = url+"&test=true";
		}
		
		
		URL obj = new URL(url);
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();

		// optional default is GET
		con.setRequestMethod("GET");
		con.setConnectTimeout(5000); //set timeout to 5 seconds


		int responseCode = con.getResponseCode();
		if(responseCode != 200){
			BufferedReader in = new BufferedReader(
			        new InputStreamReader(con.getErrorStream()));
			String inputLine;
			StringBuffer response = new StringBuffer();

			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();
			throw new Exception("Server error "+response);
		}

		BufferedReader in = new BufferedReader(
		        new InputStreamReader(con.getInputStream()));
		String inputLine;
		StringBuffer response = new StringBuffer();

		while ((inputLine = in.readLine()) != null) {
			response.append(inputLine);
		}
		in.close();
		
		return response.toString();

	}

	
	private void sendError(String error){

		String url = host+"/printer.php?pass="+pass+"&error="+error;

		URL obj;
		try {
			obj = new URL(url);
		
			HttpURLConnection con = (HttpURLConnection) obj.openConnection();	
			// optional default is GET
			con.setRequestMethod("GET");
			con.setConnectTimeout(5000); //set timeout to 5 seconds				
			con.getResponseCode();
		
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		

	}

}
