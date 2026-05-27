package com.onegamematkafun.appm.appm.responseclass;

public class DataPlaying {


    public String getDigit() {
        return digit;
    }

    public void setDigit(String digit) {
        this.digit = digit;
    }

    String game_id,game_type,game_subtype,session,bid_points,open_digit,close_digit,open_panna,close_panna,pana,digit;

    public void setGame_subtype(String game_subtype) {
        this.game_subtype = game_subtype;
    }

    public DataPlaying(String game_id, String game_type, String session, String bid_points, String open_digit, String close_digit, String open_panna, String close_panna,String pana) {
        this.game_id = game_id;
        this.game_type = game_type;
        this.session = session;
        this.bid_points = bid_points;
        this.open_digit = open_digit;
        this.close_digit = close_digit;
        this.open_panna = open_panna;
        this.close_panna = close_panna;
        this.pana = pana;
    }

    public String getGame_id() {
        return game_id;
    }

    public String getGame_type() {
        return game_type;
    }

    public String getSession() {
        return session;
    }

    public String getBid_points() {
        return bid_points;
    }

    public String getOpen_digit() {
        return open_digit;
    }

    public String getClose_digit() {
        return close_digit;
    }

    public String getPana() {
        return pana;
    }

    public void setPana(String pana) {
        this.pana = pana;
    }

    public String getOpen_panna() {
        return open_panna;
    }

    public String getClose_panna() {
        return close_panna;
    }
}
