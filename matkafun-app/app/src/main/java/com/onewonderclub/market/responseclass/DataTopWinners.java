package com.onewonderclub.market.responseclass;

import com.google.gson.annotations.SerializedName;
import java.util.List;

public class DataTopWinners {
    private String status;
    private String message;
    private String code;
    private List<Data> data;

    public String getStatus() {
        return status;
    }

    public String getMessage() {
        return message;
    }

    public String getCode() {
        return code;
    }

    public List<Data> getData() {
        return data;
    }

    public static class Data {
        @SerializedName("username")
        private String username;
        @SerializedName("win_amount")
        private String win_amount;
        @SerializedName("game_name")
        private String game_name;
        @SerializedName("game_type")
        private String game_type;

        public String getUsername() {
            return username;
        }

        public String getWinAmount() {
            return win_amount;
        }

        public String getGameName() {
            return game_name;
        }

        public String getGameType() {
            return game_type;
        }
    }
}
