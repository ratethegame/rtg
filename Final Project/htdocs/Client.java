import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.io.*;

public class Client {
    private static Interface stub = null;
    private Client() {}

    public static void main(String[] args) {

	String file = "";
	try {
	    Registry reg = LocateRegistry.getRegistry("localhost");
	    stub = (Interface) reg.lookup("RTG");
	    
	} catch (Exception e) {
	    System.err.println("Client exception thrown: " + e.toString());
	    e.printStackTrace();
	}
		System.out.println("args.length" +args.length);
		System.out.println("args[0]" +args[0]);
		System.out.println("args[1]" +args[1]);

        if (args.length == 2) {
			try {
			file = args[0];
			BufferedReader reader = new BufferedReader(new InputStreamReader(new FileInputStream(file), "UTF-8" ) );

			String[] arg = new String[20];
			String line = "";
			int j=0;
			while ((line = reader.readLine()) != null) {
				arg[j] = line;
				j++;
			}
			
			int size = arg.length;
			for(int i=0; i<j; i++)
			{
				if(i!=11 && size > 3)//bo nie zamieniamy podkreslenia w nicku Zbyszek
					arg[i] = arg[i].replaceAll("_", " ");
				if(i!=1 && size < 3)//bo nie zamieniamy podkreslenia w nicku Lukasz
					arg[i] = arg[i].replaceAll("_", " ");
				//System.out.println(arg[i]);
			}
			
			String output = "400";
			int wynik=0;
			if(args[1].equals("add")) //~~~~~~~~~~~~~~~~kiedy?
			{
				wynik = stub.dodaj(arg[0], arg[1], arg[2], arg[3], arg[4], arg[5], arg[6], arg[7], arg[8], arg[9], arg[10], arg[11], arg[12]);
			}
			else
			{
				if(args[1].equals("koment")) 
				{
					wynik = stub.dodaj_komentarz(arg[0], arg[1], arg[2]);
				}
				if(args[1].equals("ocen")) 
				{
					wynik = stub.dodaj_ocene(arg[0], arg[1], arg[2]);
				}
			}
			output = Integer.toString(wynik);
			System.out.println(output);
			
			
			}
			catch (Exception e) {
				System.out.println("Wrong input " + e.getMessage() );
				System.exit(0);
			}
        } else {
            System.out.println("Niepoprwana liczba argumentow!");
            System.exit(0);
        }        
        
    }
}
