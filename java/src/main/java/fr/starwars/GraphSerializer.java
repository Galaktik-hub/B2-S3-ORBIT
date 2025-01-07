package fr.starwars;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Objects;

public class GraphSerializer {

    public static boolean writeSerializedGraph(Graphe graph, String fileName) {
        Objects.requireNonNull(graph, "Graph must not be null");

        File outputFile = new File(fileName);

        try {
            // Vérifie si le fichier existe, sinon le crée
            if (!outputFile.exists() && !outputFile.createNewFile()) {
                System.err.println("Impossible de créer le fichier.");
                return false;
            }

            // Écriture directe dans le fichier
            try (BufferedWriter writer = new BufferedWriter(new FileWriter(outputFile))) {
                int counter = 0;
                int lastId = 0;

                writer.write(graph.getAretes().size() + " " + graph.getPlanetes().size() + "\n");

                // Écrit le nombre d'arêtes et le dernier ID de planète
                for (Planete p : graph.getPlanetes()) {
                    int numberOfArete = graph.getNumberOfArete(p);
                    writer.write(p.getId() + " " + counter + " " + numberOfArete + " " +
                            p.getRealCordX() + " " + p.getRealCordY() + "\n");
                    counter += numberOfArete;
                    lastId = p.getId();
                }

                writer.write(counter + " " + lastId + "\n-\n");

                // Écrit les arêtes
                for (Arete a : graph.getAretes()) {
                    writer.write(a.getSource().getId() + " " +
                            a.getDistance() + " " +
                            a.getDestination().getId() + "\n");
                }

                return true; // Succès
            }
        } catch (IOException e) {
            System.err.println("Erreur lors de l'écriture dans le fichier : " + e.getMessage());
            e.printStackTrace();
            return false; // Échec
        }
    }
}
