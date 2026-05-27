package com.onegamematkafun.market.responseclass;

public class DataNotification {
    private String title;
    private String message;
    private String createdAt;

    public DataNotification(String title, String message, String createdAt) {
        this.title = title;
        this.message = message;
        this.createdAt = createdAt;
    }

    public String getTitle() {
        return title;
    }

    public String getMessage() {
        return message;
    }

    public String getCreatedAt() {
        return createdAt;
    }
}
