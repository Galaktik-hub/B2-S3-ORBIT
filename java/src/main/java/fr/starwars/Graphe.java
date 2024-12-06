package fr.starwars;

import java.util.ArrayList;
import java.util.List;

public class Graphe {
    private List<Planete> planetes = new ArrayList<>();
    private List<Arete> aretes = new ArrayList<>();

    public void ajouterPlanete(Planete planete) {
        planetes.add(planete);
    }

    public void ajouterArete(Arete arete) {
        aretes.add(arete);
    }

    public List<Planete> getPlanetes() {
        return planetes;
    }

    public List<Arete> getAretes() {
        return aretes;
    }

    public int getLength() { return aretes.size(); }

    public int getNumberOfArete(Planete planete) {
        int n = 0;
        for (Arete arete : aretes) {
            if (arete.getSource().getId() == planete.getId() || arete.getDestination().getId() == planete.getId()) {
                n++;
            }
        }
        return n;
    }

    public Planete findPlaneteById(int id) {
        for (Planete p : this.getPlanetes()) {
            if (p.getId() == id) {
                return p;
            }
        }
        return null;
    }
}
