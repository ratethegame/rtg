import java.sql.*;

public class DbConnect {
    private Connection con;
    private Statement st;
    private ResultSet rs;
    
    public DbConnect() {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            
            con = DriverManager.getConnection("jdbc:mysql://db4free.net/rtgbase", "adminrtg", "ratethegame");
            st = con.createStatement();
        } catch(Exception e) {
            System.out.println("Error: "+e);
        }
    }
    
	public void insert_platforma(int id_gra, String platformy)
	{
		String[] platforma = platformy.split(";");
		int size = platforma.length;
		for(int i=0; i<size; i++)
		{
			try {
				String select_platforma = "SELECT id FROM Platforma WHERE nazwa = '" + platforma[i] + "'";
				rs = st.executeQuery(select_platforma);
				int id_platforma = -1;
				while(rs.next())
					id_platforma = rs.getInt("id");
					
				String insert = "INSERT INTO Gra_platforma (id_gra, id_platforma) VALUES (" + id_gra + ", " + id_platforma +")";
				st.executeUpdate(insert);
			} catch(Exception e) {
				System.out.println("Error: "+e);
			}
		}
	}
	
	public void insert_obrazki(int id_gra, String okladka, String screeny)
	{
		try {	
			String insert_okladka = "INSERT INTO Obrazki (id_gry, link, typ) VALUES (" + id_gra + ", '" + okladka +"', 'okladka')";
			st.executeUpdate(insert_okladka);
			
			if (!screeny.equals("NULL"))
			{
				String[] screen = screeny.split(";");
				int size = screen.length;
				for(int i=0; i<size; i++)
				{
					if(!screen[i].isEmpty())
					{
						String insert_screen = "INSERT INTO Obrazki (id_gry, link, typ) VALUES (" + id_gra + ", '" + screen[i] +"', 'screen')";
						st.executeUpdate(insert_screen);
					}
				}
			}
		} catch(Exception e) {
				System.out.println("Error: "+e);
		}
	}
	
	public void insert_filmiki(int id_gra, String trailery, String gameplaye)
	{
		try {
			if (!trailery.equals("NULL"))
			{
				String[] trailer = trailery.split(";");
				int size = trailer.length;
				for(int i=0; i<size; i++)
				{
					if(!trailer[i].isEmpty())
					{
						String insert_trailer = "INSERT INTO Filmiki (id_gry, link, typ) VALUES (" + id_gra + ", '" + trailer[i] +"', 'trailer')";
						st.executeUpdate(insert_trailer);
					}
				}
			}
			
			if (!gameplaye.equals("NULL"))
			{
				String[] gameplay = gameplaye.split(";");
				int size = gameplay.length;
				for(int i=0; i<size; i++)
				{
					if(!gameplay[i].isEmpty())
					{
						String insert_gameplay = "INSERT INTO Filmiki (id_gry, link, typ) VALUES (" + id_gra + ", '" + gameplay[i] +"', 'gameplay')";
						st.executeUpdate(insert_gameplay);
					}
				}
			}
		} catch(Exception e) {
				System.out.println("Error: "+e);
		}
	}
	
    public int insert(String s_nazwa, String s_data_s, String s_data_p, String s_gatunek, String s_wydawca, String s_platforma, String s_opis, String s_okladka, String s_screen, String s_trailer, String s_gameplay, String s_dodal, String s_dodano_czas) {
        int wynik = -1;
		try {
            String insert = "INSERT INTO Gra (nazwa, rok_wydania_swiat, rok_wydania_polska, gatunek, wydawca, opis, dodal, dodano_czas) VALUES ('" + s_nazwa + "','" + s_data_s + "','" + s_data_p + "','" + s_gatunek + "','" + s_wydawca + "','" + s_opis + "','" + s_dodal + "','" + s_dodano_czas +"')";
            wynik = st.executeUpdate(insert);
			
			String select_game = "SELECT id FROM Gra WHERE nazwa = '" + s_nazwa + "' AND opis = '" + s_opis + "' AND dodal = '" + s_dodal + "' AND dodano_czas = '" + s_dodano_czas +"'";
			rs = st.executeQuery(select_game);
			int id_gra = -1;
			while(rs.next())
                id_gra = rs.getInt("id");
			
			insert_platforma(id_gra, s_platforma);
			insert_obrazki(id_gra, s_okladka, s_screen);
			insert_filmiki(id_gra, s_trailer, s_gameplay);
        } catch(Exception e) {
            System.out.println("Error: "+e);
        }
		return wynik;
    }
}
