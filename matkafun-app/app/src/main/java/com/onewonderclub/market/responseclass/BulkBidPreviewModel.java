package com.onewonderclub.market.responseclass;

public class BulkBidPreviewModel {
    private String panna;
    private int points;
    private String session;

    public BulkBidPreviewModel(String panna, int points, String session) {
        this.panna = panna;
        this.points = points;
        this.session = session;
    }

    public String getPanna() { return panna; }
    public int getPoints() { return points; }
    public String getSession() { return session; }
}
