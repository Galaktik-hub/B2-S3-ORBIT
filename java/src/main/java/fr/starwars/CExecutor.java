package fr.starwars;

import java.io.BufferedReader;
import java.io.File;
import java.io.InputStreamReader;

public class CExecutor {
    public static void main(String[] args) {
        if (args.length != 4) {
            System.err.println("Usage : ");
            System.exit(1);
        }

        try {
            // Construire la commande
            ProcessBuilder pb = new ProcessBuilder(args[0], args[1], args[2], args[3]);
            pb.directory(new File("."));

            // Démarrer le processus
            Process process = pb.start();

            // Lire la sortie du programme C
            BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()));
            String line;
            while ((line = reader.readLine()) != null) {
                System.out.println(line);
            }

            // Attendre la fin de l'exécution
            int exitCode = process.waitFor();
            if (exitCode == 0) {
                System.out.println("Programme C exécuté avec succès !");
            } else {
                System.err.println("Erreur lors de l'exécution du programme C, code : " + exitCode);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
