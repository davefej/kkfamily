package kkprint;


import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.text.Normalizer;
import java.text.SimpleDateFormat;
import java.util.Base64;
import java.util.Date;
import java.util.Scanner;

import javax.swing.JOptionPane;

public class Main {
	
		Print printer = null;
		HTTPConnection web = null;
		String zpl_cache;
		
		Main(String[] args){
			
			printer = new Print(this);
			
			if(!(new File("printer.txt")).exists()){
				log("printer.txt hiányzik. Tartalma a géphez csatlakoztatott nyomtató száma.");
				alert("printer.txt hiányzik. Listázza a printereket a másik alkalmazással");
				System.exit(1);
			}
			
			if(!(new File("db.txt")).exists()){
				log("db.txt hiányzik. Tartalma: webhost#_#...#_#dbpass2");
				alert("db.txt hiányzik. Tartalma: webhost#_#...#_#dbpass2");
				System.exit(1);
			}
			
			try {
				@SuppressWarnings("resource")
				Scanner sc = new Scanner(new File("db.txt"));
				String[] webconf = null;
				if(sc.hasNext()){
					String line = sc.nextLine();
					webconf = line.split("#_#");
					if(webconf.length == 2){//nincs jelszó
						String[] tmp = new String[3];
						tmp[0] = webconf[0];
						tmp[1] = webconf[1];
						tmp[2] = "";
						webconf = tmp;
					}
					webconf[2] = decode(webconf[2]);
					log("dbconf loaded!");
				}
				web = new HTTPConnection(this,webconf[0],webconf[1],webconf[2]);
				web.test();
				setPrinter();
				setZpl();
			} catch (Exception e) {				
				e.printStackTrace();
				error("init error "+e.toString());
				alert("Inícializálási HIBA: "+e.toString()+" \n Ellenőrizze az internet kapcsolatot valamint a nyomtatóval a kábelösszeköttetést");
				System.exit(1);
			}		
		
			int i = 1;
			int sum = 0;
			boolean last = false;
			int first = 1000;
		
			while(true){
				
				if(new File("stop.txt").exists()){
					alert("stop.txt miatt leállás");
					System.exit(1);
				}
				
				
				int count = web.exec();				
				
				sum += count;
				
				int sleep = 10000;				
				if(last){
					sleep = 5000;
				}
				if(sum > 0){
					sleep = 2500;					
				}
				if(first > 0){
					first--;
					sleep = 2500;
				}
			
				
				try {					
					Thread.sleep(sleep);
				} catch (InterruptedException e) {
					error("thread sleep error "+e.toString());
					alert("thread sleep HIBA\n kérjük indítsa újra a progamot");
					System.exit(1);
				}
				
				if(i == 999){
					if(sum > 0){
						last = true;
					}else{
						last = false;
					}
					sum = 0;
					i = 1;				
				}
				i++;				
			}			
	}
	
	private String decode(String string) throws UnsupportedEncodingException {
			String str =  new String(Base64.getDecoder().decode(string.getBytes("UTF-8")),"UTF-8");
			return str;
		}

	public static void main(String[] args){
		new Main(args);
	}
	
	
	
	private void setPrinter() throws FileNotFoundException{
		Scanner sc;
		if((new File("printer.txt")).exists()){
			sc = new Scanner(new File("printer.txt"));
		}else{
			System.out.println("Adja meg a printer azonosító számát!\n(nyomtatók listázásához indítsa el a programot -p argumentummal)");
			sc = new Scanner(System.in);
		}
		
		if(sc.hasNext()){
			String line = sc.nextLine();
			printer.choosePrinter(Integer.parseInt(line));
			log("Nyomtató azonosító :"+ line);
		}
		sc.close();
	}
	
	public boolean print(int id, int amount, String prod, String date, String suppl,String unit) {
		String zpl = zpl_cache;
		date = date.substring(0,10);
		String date_amount = date+"  "+amount+" "+unit;
		
		if(suppl.length() > 25){
			suppl = suppl.substring(0, 24);
		}
		if(prod.length() > 25){
			prod = prod.substring(0, 24);
		}
		if(date_amount.length() > 25){
			date_amount = date_amount.substring(0, 24);
		}
		
		zpl = zpl.replace("#id#", ""+id);
		zpl = zpl.replace("#id#", ""+id);//direkt 2X
		zpl = zpl.replace("#date_amount#",date_amount);
		zpl = zpl.replace("#prod#", prod);
		zpl = zpl.replace("#suppl#", suppl);
		zpl = ekezetKill(zpl);
		return printer.printJob(zpl);
	}
	
	public void setZpl() throws FileNotFoundException{
		Scanner sc;
		if((new File("zpl.txt")).exists()){
			sc = new Scanner(new File("zpl.txt"));
			if(sc.hasNext()){
				String line = sc.nextLine();
				zpl_cache = line;
				log("zpl from file "+zpl_cache);
			}
		}else{
			zpl_cache =  "^XA  ^MTD ^CFA,30   ^FO170,30^FD#prod#^FS  ^FO170,65^FD#suppl#^FS  ^FO170,100^FD#date_amount#^FS  ^BY3,3,100 ^FO170,150 ^BC^FD#id#^FS ^FO500,60 ^BQN,2,7 ^FDMM,A#id#^FS ^XZ";
			log("zpl from code "+zpl_cache);
		}		
	}
	
	
	
	public String ekezetKill(String str){
		str = replaceAllStr("á","a",str);
		str = replaceAllStr("é","e",str);
		str = replaceAllStr("í","i",str);
		str = replaceAllStr("ó","o",str);
		str = replaceAllStr("ö","o",str);
		str = replaceAllStr("ő","o",str);
		str = replaceAllStr("ú","u",str);
		str = replaceAllStr("ü","u",str);
		str = replaceAllStr("ű","u",str);
		str = replaceAllStr("Á","A",str);
		str = replaceAllStr("É","E",str);
		str = replaceAllStr("Í","I",str);
		str = replaceAllStr("Ó","O",str);
		str = replaceAllStr("Ö","O",str);
		str = replaceAllStr("Ő","O",str);
		str = replaceAllStr("Ú","U",str);
		str = replaceAllStr("Ü","U",str);
		str = replaceAllStr("Ű","U",str);
		return str;
		
	}
	
	public String replaceAllStr(String old,String New, String str){
		while(str.contains(old)){
			str = str.replace(old, New);
		}
		return stripAccents(str);
	}
	
	public static String stripAccents(String s) 
	{
	    s = Normalizer.normalize(s, Normalizer.Form.NFD);
	    s = s.replaceAll("[\\p{InCombiningDiacriticalMarks}]", "");
	    return s;
	}
	
	public void error(String txt){
		try {
		    PrintWriter out = new PrintWriter(new BufferedWriter(new FileWriter("error.txt", true)));
		    DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		    Date date = new Date();		   
		    out.println("\n"+dateFormat.format(date)+"\n"+txt+"\n");
		    out.close();
		    
		    System.out.println("\n"+dateFormat.format(date)+"\n"+txt+"\n");
		    
		} catch (IOException e) {
		   
		}
	}
	
	public void log(String txt){
		try {
		    PrintWriter out = new PrintWriter(new BufferedWriter(new FileWriter("log.txt", true)));
		    DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
		    Date date = new Date();		   
		    out.println("\n"+dateFormat.format(date)+"\n"+txt+"\n");
		    out.close();
		    
		    System.out.println("\n"+dateFormat.format(date)+"\n"+txt+"\n");
		    
		} catch (IOException e) {
		   
		}
	}
	
	public void alert(String str){
		JOptionPane.showMessageDialog(null,str);
	}
}
