import java.sql.Time;

public class Arete {
    private Planete source;
    private Planete destination;
    private Time time;

    public Arete(Planete source, Planete destination, Time time) {
        this.source = source;
        this.destination = destination;
        this.time = time;
    }

    public Planete getSource() {
        return source;
    }

    public Planete getDestination() {
        return destination;
    }

    public Time getTime() {
        return time;
    }

    public int getDistance() {
        
    }
}
