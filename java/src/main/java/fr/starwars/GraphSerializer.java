package fr.starwars;

public class GraphSerializer {

    public static String serializeGraph(Graphe graph) {
        StringBuilder sbPlanets = new StringBuilder();
        StringBuilder sbArete = new StringBuilder();

        int counter = 0;

        for (Planete p : graph.getPlanetes()) {
            int numberOfArete = graph.getNumberOfArete(p);
            sbPlanets.append(p.getId()).append(" ")
                     .append(counter).append(" ")
                     .append(numberOfArete).append("\n");
            counter += numberOfArete;
        }

        for (Arete a : graph.getAretes()) {
            sbArete.append(a.getSource().getId()).append(" ")
                    .append(a.getDistance()).append(" ")
                    .append(a.getDestination().getId()).append("\n");
        }

        return sbPlanets + "\n-\n" + sbArete;
    }
}
