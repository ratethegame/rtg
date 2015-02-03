import java.rmi.RemoteException;

public class InterfaceImpl implements Interface {
	
    public int dodaj_komentarz(String game_title, String user_nickname, String comment) throws RemoteException {
		DbConnect connect = new DbConnect();
        int wynik = 400;	//error
		int wynik_ins = connect.insert_comment(game_title, user_nickname, comment);
		System.out.println(wynik_ins);
		if (wynik_ins == 1)
			wynik = 200;	//ok
        return wynik;
    }


    public int dodaj_ocene(String game_title, String user_nickname, String rate) throws RemoteException {
		DbConnect connect = new DbConnect();
        int wynik = 400;
		int wynik_ins = connect.insert_rate(game_title, user_nickname, rate);
		System.out.println(wynik_ins);
		if (wynik_ins == 1)
			wynik = 200;
        return wynik;
    }

    public int dodaj(String nazwa, String data_s, String data_p, String gatunek, String wydawca, String platforma, String opis, String okladka, String screen, String trailer, String gameplay, String dodal, String dodano_czas) throws RemoteException {
		DbConnect connect = new DbConnect();
        int wynik = 400;
		int wynik_ins = connect.insert(nazwa, data_s, data_p, gatunek, wydawca, platforma, opis, okladka, screen, trailer, gameplay, dodal, dodano_czas);
		System.out.println(wynik_ins);
		if (wynik_ins == 1)
			wynik = 200;
        return wynik;
    }
}