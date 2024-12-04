package fr.starwars;

public class Planete {
    private int id;
    private String nom;
    private float coordX;
    private float coordY;

    public Planete(int id, String nom, float coordX, float coordY) {
        this.id = id;
        this.nom = nom;
        this.coordX = coordX;
        this.coordY = coordY;
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
