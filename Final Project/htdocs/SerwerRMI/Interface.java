import java.rmi.Remote;
import java.rmi.RemoteException;

public interface Interface extends Remote {
    public int dodaj_komentarz(String game_title, String user_nickname, String comment)
                    throws RemoteException;

    public int dodaj_ocene(String game_title, String user_nickname, String rate)
                    throws RemoteException;

    public int dodaj(String nazwa, String data_s, String data_p, String gatunek, String wydawca, String platforma, String opis, String okladka, String screen, String trailer, String gameplay, String dodal, String dodano_czas)
                    throws RemoteException;
}
