package fr.starwars;
import java.sql.*;

public class Main {
    public static void main(String[] args) {
        DatabaseManager db = new DatabaseManager();

        try {
            db.connect();
            Graphe graphe = new Graphe();

            Connection connection = db.getConnection();
            // Charger les planètes
            String queryPlanetes = "SELECT id, name, x, y FROM planets";
            try (Statement stmt = connection.createStatement(); ResultSet rs = stmt.executeQuery(queryPlanetes)) {
                while (rs.next()) {
                    int id = rs.getInt("id");
                    String nom = rs.getString("name");
                    float x = rs.getFloat("x");
                    float y = rs.getFloat("y");
                    Planete planete = new Planete(id, nom, x, y);
                    graphe.ajouterPlanete(planete);
                }
            }

            // Charger les trajets (trips)
            String queryTrips = "SELECT * FROM trips";
            try (Statement stmt = connection.createStatement(); ResultSet rs = stmt.executeQuery(queryTrips)) {
                while (rs.next()) {
                    int tripId = rs.getInt("id");
                    int idSource = rs.getInt("planet_id");
                    String day = rs.getString("day_of_week");
                    int idDestination = rs.getInt("destination_planet_id");
                    Time time = rs.getTime("departure_time");
                    int shipId = rs.getInt("ship_id");

                    // Trouver les planètes source et destination
                    Planete source = graphe.findPlaneteById(idSource);
                    Planete destination = graphe.findPlaneteById(idDestination);

                    Arete arete = new Arete(tripId, source, day, destination, time, shipId);
                    graphe.ajouterArete(arete);
                }
            }

            // Afficher les résultats
            System.out.println("Planètes : ");
            for (Planete p : graphe.getPlanetes()) {
//                System.out.println(p.getId() + " " + p.getNom());
                System.out.println(p);
            }

//            System.out.println("\nTrajets : ");
//            for (Arete a : graphe.getAretes()) {
//                System.out.println(a);
//            }

            System.out.println("\nNombre d'arrêtes : " + graphe.getLength());

        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

}
