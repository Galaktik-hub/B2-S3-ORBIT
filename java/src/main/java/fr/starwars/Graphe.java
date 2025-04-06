package fr.starwars;

import java.util.ArrayList;
import java.util.List;
import java.util.Objects;

public class Graphe {
    private final List<Planete> planetes = new ArrayList<>();
    private final List<Arete> aretes = new ArrayList<>();

    public void ajouterPlanete(Planete planete) {
        Objects.requireNonNull(planete, "planete must not be null");
        planetes.add(planete);
    }

    public void ajouterArete(Arete arete) {
        Objects.requireNonNull(arete, "arete must not be null");
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
        Objects.requireNonNull(planete, "planete must not be null");
        int n = 0;
        for (Arete arete : aretes) {
            if (arete.getSource().getId() == planete.getId()) {
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
