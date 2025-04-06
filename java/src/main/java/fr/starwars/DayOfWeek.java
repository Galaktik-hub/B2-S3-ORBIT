package fr.starwars;

public enum DayOfWeek {
    PRIMEDAY,
    CENTAXDAY,
    TAUNGSDAY,
    ZHELLDAY,
    BENDUDAY;

    public static DayOfWeek getDayOfWeek(String day) {
        return DayOfWeek.valueOf(day.toUpperCase());
    }
}
