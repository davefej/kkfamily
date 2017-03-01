package kkprinterlist;

import javax.print.PrintService;
import javax.print.PrintServiceLookup;
import javax.swing.JOptionPane;

public class Main {
	
	public static void main(String[] s){
		PrintService[] printServices = PrintServiceLookup.lookupPrintServices(null, null);
       
        int i=0;
        String str ="Number of print services: " + printServices.length+"\r\n";
        for (PrintService printer : printServices)
        	str += (i+++" Printer: " + printer.getName()+"\r\n"); 
        JOptionPane.showMessageDialog(null, str);
        
	}
	
	

}
