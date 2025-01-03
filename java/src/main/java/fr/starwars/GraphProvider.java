package fr.starwars;

import java.sql.*;

public class GraphProvider {
    public static boolean getGraphFromDatabase(String legion, String fileName) {
        DatabaseManager db = new DatabaseManager();

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            db.connect();
            Graphe graphe = new Graphe();

            Connection connection = db.getConnection();
            // Charger les planètes
            String queryPlanetes = "SELECT id, name, x, y, sub_grid_x, sub_grid_y FROM planets";
            try (Statement stmt = connection.createStatement(); ResultSet rs = stmt.executeQuery(queryPlanetes)) {
                while (rs.next()) {
                    int id = rs.getInt("id");
                    String nom = rs.getString("name");
                    int x = rs.getInt("x");
                    int y = rs.getInt("y");
                    float sub_gridX = rs.getFloat("sub_grid_x");
                    float sub_gridY = rs.getFloat("sub_grid_y");

                    Planete planete = new Planete(id, nom, x, y, sub_gridX, sub_gridY);
                    graphe.ajouterPlanete(planete);
                }
            }

            // Charger les trajets (trips) avec filtre basé sur le camp
            String queryTrips = "SELECT t.id, t.planet_id, t.day_of_week, t.destination_planet_id, t.departure_time, t.ship_id FROM trips t JOIN ships s ON t.ship_id = s.id WHERE s.camp = ? OR ? = 'Neutre';";

            try (PreparedStatement stmt = connection.prepareStatement(queryTrips)) {
                stmt.setString(1, legion);
                stmt.setString(2, legion);
                try (ResultSet rs = stmt.executeQuery()) {
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
            }

            boolean success = GraphSerializer.writeSerializedGraph(graphe, fileName);
            db.disconnect();

            return success;
        } catch (SQLException | ClassNotFoundException e) {
            e.printStackTrace();
        }

        return false;
    }
}
