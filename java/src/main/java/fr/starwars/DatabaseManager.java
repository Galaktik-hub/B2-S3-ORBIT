package fr.starwars;

import java.sql.*;

public class DatabaseManager {
    private static final String URL = "jdbc:mysql://localhost:3306/travia";
    private static final String USER = "travia";
    private static final String PASSWORD = "travia";

    private Connection connection;

    // Initialize connection
    public void connect() throws SQLException {
        connection = DriverManager.getConnection(URL, USER, PASSWORD);
        System.out.println("Connected to the database!");
    }

    // Close connection
    public void disconnect() throws SQLException {
        if (connection != null && !connection.isClosed()) {
            connection.close();
            System.out.println("Database connection closed.");
        }
    }

    public Connection getConnection() {
        return connection;
    }

    // Query to fetch planets
    public void fetchPlanets() throws SQLException {
        String query = "SELECT id, name, region, sector FROM planets";
        try (PreparedStatement statement = connection.prepareStatement(query)) {
            ResultSet resultSet = statement.executeQuery();
            while (resultSet.next()) {
                System.out.println("Planet ID: " + resultSet.getInt("id"));
                System.out.println("Name: " + resultSet.getString("name"));
                System.out.println("Region: " + resultSet.getString("region"));
                System.out.println("Sector: " + resultSet.getString("sector"));
                System.out.println("-----------------------------");
            }
        }
    }
}
