package fr.starwars;

import java.sql.Time;
import java.util.Objects;

public class Arete {
    private final int tripId;
    private final DayOfWeek dayOfWeek;
    private final Planete source;
    private final Planete destination;
    private final Time time;
    private final int shipId;

    public Arete(int tripId, Planete source, String day, Planete destination, Time time, int shipId) {
        if (tripId < 0) {
            throw new IllegalArgumentException("tripId must be a positive integer");
        }
        this.tripId = tripId;
        Objects.requireNonNull(day, "day must not be null");
        this.dayOfWeek = DayOfWeek.getDayOfWeek(day);
        this.source = Objects.requireNonNull(source, "source must not be null");
        this.destination = Objects.requireNonNull(destination, "destination must not be null");
        this.time = Objects.requireNonNull(time, "time must not be null");
        if (shipId < 0) {
            throw new IllegalArgumentException("shipId must be a positive integer");
        }
        this.shipId = shipId;
    }

    public int getTripId() { return tripId; }

    public Planete getSource() {
        return source;
    }

    public DayOfWeek getDayOfWeek() { return dayOfWeek; }

    public Planete getDestination() {
        return destination;
    }


    public Time getTime() {
        return time;
    }

    public int getShipId() { return shipId; }

    public float getDistance() {
        float x1 = (source.getCoordX() + source.getSub_gridX()) * 6;
        float y1 = (source.getCoordY() + source.getSub_gridY()) * 6;
        float x2 = (destination.getCoordX() + destination.getSub_gridX()) * 6;
        float y2 = (destination.getCoordY() + destination.getSub_gridY()) * 6;

        return (float) Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
    }

    @Override
    public String toString() {
        final StringBuilder sb = new StringBuilder();
        sb.append("tripId : ").append(tripId);
        sb.append(" | dayOfWeek : ").append(dayOfWeek);
        sb.append(" | Departure : ").append(source.getNom());
        sb.append(" | Arrival : ").append(destination.getNom());
        sb.append(" | time : ").append(time);
        sb.append(" | shipId : ").append(shipId);
        return sb.toString();
    }
}
