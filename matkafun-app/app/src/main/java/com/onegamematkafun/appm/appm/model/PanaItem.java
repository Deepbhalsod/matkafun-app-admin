package com.onegamematkafun.appm.appm.model;

public class PanaItem {
    private String digit;
    private String pana;
    private String points;

    public PanaItem(String digit, String pana, String points) {
        this.digit = digit;
        this.pana = pana;
        this.points = points;
    }

    public String getDigit() { return digit; }
    public String getPana() { return pana; }
    public String getPoints() { return points; }
}
