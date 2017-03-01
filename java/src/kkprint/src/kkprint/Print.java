package kkprint;


import javax.print.Doc;
import javax.print.DocFlavor;
import javax.print.DocPrintJob;
import javax.print.PrintService;
import javax.print.PrintServiceLookup;
import javax.print.SimpleDoc;


public class Print {
	
	private int printerid = -1;
	private PrintService pservice = null;	
	Main main;
	
	Print(Main m){
		main = m;
	}
	
	public boolean printJob(String str){
		if(printerid < 0 || pservice == null){
			return false;
		}

		DocPrintJob job = pservice.createPrintJob();  		
		String commands = str;
		DocFlavor flavor = DocFlavor.BYTE_ARRAY.AUTOSENSE;
		Doc doc = null;
		try {
			doc = new SimpleDoc(commands.getBytes("UTF-8"), flavor, null);
		
			if(job != null){								
				job.print(doc, null);
				main.log("********\nprint\n**********\n"+str+"\n");
			}
				
		} catch (Exception e) {
			main.error("printjob error"+e.toString());
			return false;
		}
		return true;
	}
	
	public  void list()
    {
        PrintService[] printServices = PrintServiceLookup.lookupPrintServices(null, null);
        System.out.println("Number of print services: " + printServices.length);
        int i=0;
        for (PrintService printer : printServices)
            System.out.println(i+++" Printer: " + printer.getName()); 
    }
	
	public void choosePrinter(int printerid){
		this.printerid = printerid;
		PrintService[] printServices = PrintServiceLookup.lookupPrintServices(null, null);
		pservice = printServices[printerid];
	}

	
	
	
}
