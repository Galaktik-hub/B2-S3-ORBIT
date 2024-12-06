package fr.starwars;

import java.util.Objects;

public class Planete {
    private final int id;
    private final String nom;
    private final int coordX;
    private final int coordY;
    private final float sub_gridX;
    private final float sub_gridY;

    public Planete(int id, String nom, int coordX, int coordY, float sub_gridX, float sub_gridY) {
        this.id = id;
        this.nom = Objects.requireNonNull(nom);
        this.coordX = coordX;
        this.coordY = coordY;
        this.sub_gridX = sub_gridX;
        this.sub_gridY = sub_gridY;
    }

    public int getId() {
        return id;
    }

    public String getNom() {
        return nom;
    }

    public float getCoordX() {
        return coordX;
    }

    public float getCoordY() {
        return coordY;
    }

    public float getSub_gridX() { return sub_gridX; }

    public float getSub_gridY() { return sub_gridY; }

    @Override
    public String toString() {
        final StringBuilder sb = new StringBuilder();
        sb.append("id : ").append(id);
        sb.append(" | nom : '").append(nom).append('\'');
        sb.append(" | coordX : ").append(coordX);
        sb.append(" | coordY : ").append(coordY);
        return sb.toString();
    }
}
