package fr.starwars;

import java.io.BufferedReader;
import java.io.File;
import java.io.InputStreamReader;

public class CExecutor {
    public static void main(String[] args) {
        if (args.length != 4) {
            System.err.println("Usage : [exe_name] [id_planet_departure] [id_planet_destination] [legion_name]");
            System.exit(1);
        }

        try {
            String graph_path = "";
            switch (args[3]) {
                case "Neutre":
                    graph_path = "data/serialized_graph_neutral.txt";
                    break;
                case "Rebelles":
                    graph_path = "data/serialized_graph_rebelles.txt";
                    break;
                case "Empire":
                    graph_path = "data/serialized_graph_empires.txt";
                    break;
                default:
                    System.err.println("Invalid legion name. Choose between Neutre, Rebelles, Empire.");
                    System.exit(1);
            }

            File graph = new File(graph_path);

            boolean success = GraphProvider.getGraphFromDatabase(args[3], graph.toString());

            if (!success) {
                System.err.println("Erreur lors de la sérialisation du graphe depuis la base de données.");
                System.exit(1);
            } else {
                System.out.println("Graphe sérialisé avec succès !");
            }

            // Construire la commande
            ProcessBuilder pb = new ProcessBuilder(args[0], graph.toString(), args[1], args[2]);
            pb.directory(new File("."));

            // Démarrer le processus
            Process process = pb.start();

            // Lire la sortie du programme C
            BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()));
            String line;
            StringBuilder sb = new StringBuilder();
            while ((line = reader.readLine()) != null) {
                sb.append(line);
            }

            // Attendre la fin de l'exécution
            int exitCode = process.waitFor();
            boolean deleted = true;
            if (exitCode == 0) {
                System.out.println(sb.toString());
            } else {
                System.err.println("Erreur lors de l'exécution du programme C, code : " + exitCode);
            }
            deleted = graph.delete();

            if (!deleted) {
                System.err.println("Erreur lors de la suppression du fichier graphe.");
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
