package fr.starwars;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Objects;

public class GraphSerializer {

    public static String serializeGraph(Graphe graph) {
        Objects.requireNonNull(graph, "graph must not be null");
        StringBuilder sbPlanets = new StringBuilder();
        StringBuilder sbArete = new StringBuilder();

        int counter = 0;
        int lastId = 0;

        for (Planete p : graph.getPlanetes()) {
            int numberOfArete = graph.getNumberOfArete(p);
            sbPlanets.append(p.getId()).append(" ")
                    .append(counter).append(" ")
                    .append(numberOfArete).append(" ")
                    .append(p.getRealCordX()).append(" ")
                    .append(p.getRealCordY()).append("\n");
            counter += numberOfArete;
            lastId = p.getId();
        }

        for (Arete a : graph.getAretes()) {
            sbArete.append(a.getSource().getId()).append(" ")
                    .append(a.getDistance()).append(" ")
                    .append(a.getDestination().getId()).append("\n");
        }

        return counter + " " + lastId + "\n" + sbPlanets + "-\n" + sbArete;
    }

    public static boolean writeSerializedGraph(Graphe graph, String fileName) {
        Objects.requireNonNull(graph, "Graph must not be null");

        String serializedGraph = serializeGraph(graph);

        File outputFile = new File(fileName);

        try {
            // Vérifie si le fichier existe, sinon le crée
            if (!outputFile.exists()) {
                if (!outputFile.createNewFile()) {
                    System.err.println("Impossible de créer le fichier.");
                    return false;
                }
            }

            // Écriture dans le fichier
            try (BufferedWriter writer = new BufferedWriter(new FileWriter(outputFile))) {
                writer.write(serializedGraph);
                return true; // Succès
            }
        } catch (IOException e) {
            System.err.println("Erreur lors de l'écriture dans le fichier : " + e.getMessage());
            e.printStackTrace();
            return false; // Échec
        }
    }
}
