import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;

public class Client {
    private static Interface stub = null;
    private Client() {}

    public static void main(String[] args) {
	
	String nazwa = "";
	String data_s = "";
	String data_p = "";
	String gatunek = "";
	String wydawca = "";
	String platforma = "";
	String opis = "";
	String okladka = "";
	String screen = "";
	String trailer = "";
	String gameplay = "";
	String dodal = "";
	String dodano_czas = "";
	
	
	try {
	    Registry reg = LocateRegistry.getRegistry("localhost");
	    stub = (Interface) reg.lookup("RTG");
	    
	} catch (Exception e) {
	    System.err.println("Client exception thrown: " + e.toString());
	    e.printStackTrace();
	}
        if (args.length == 13) {
           try {
			nazwa = args[0].replaceAll("_", " ");
			data_s = args[1];
			data_p = args[2];
			gatunek = args[3].replaceAll("_", " ");
			wydawca = args[4].replaceAll("_", " ");
			platforma = args[5];	//platformy są oddzielone srednikami
			opis = args[6].replaceAll("_", " ");
			okladka = args[7];
			screen = args[8];	//screeny są oddzielone srednikami
			trailer = args[9];	//trailery są oddzielone srednikami
			gameplay = args[10];	//gameplaye są oddzielone srednikami
			dodal = args[11].replaceAll("_", " ");
			dodano_czas = args[12];
           
			String output = "400";
			int wynik = stub.dodaj(nazwa, data_s, data_p, gatunek, wydawca, platforma, opis, okladka, screen, trailer, gameplay, dodal, dodano_czas);
			output = Integer.toString(wynik);
			System.out.println(output);
		   
		   }
           catch (Exception e) {
              System.out.println("Wrong input " + e.getMessage() );
              System.exit(0);
           }
		   
		   
		   
		   
		   
           //wypisz(nazwa, data_s, data_p, gatunek, wydawca, platforma, opis, okladka, screen, trailer, gameplay, dodal, dodano_czas);
        
        } else {
            System.out.println("Niepoprwana liczba argumentow!");
            System.exit(0);
        }        
        
    }
    
    public static void wypisz(String nazwa, String data_s, String data_p, String gatunek, String wydawca, String platforma, String opis, String okladka, String screen, String trailer, String gameplay, String dodal, String dodano_czas)
	{        
		int wynik = 400;
		try {
            wynik = stub.dodaj(nazwa, data_s, data_p, gatunek, wydawca, platforma, opis, okladka, screen, trailer, gameplay, dodal, dodano_czas);
        } catch(Exception e) {
            System.out.println("Remote method exception thrown: " + e.getMessage());
        }
		
		if (wynik == 400)	//error
			System.out.println("Wystąpił nieoczekiwany błąd. Spróbuj jeszcze raz");

		if (wynik == 200)	//ok
			System.out.println("Gra dodana poprawnie");
    }
}
