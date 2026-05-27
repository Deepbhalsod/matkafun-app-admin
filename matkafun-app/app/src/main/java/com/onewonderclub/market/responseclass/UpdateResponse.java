package com.onewonderclub.market.responseclass;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class UpdateResponse {

    @SerializedName("latest_version")
    @Expose
    private String latestVersion;

    @SerializedName("min_supported_version")
    @Expose
    private String minSupportedVersion;

    @SerializedName("is_update_forced")
    @Expose
    private boolean isUpdateForced;

    @SerializedName("update_url")
    @Expose
    private String updateUrl;

    @SerializedName("update_message")
    @Expose
    private String updateMessage;

    public String getLatestVersion() {
        return latestVersion;
    }

    public void setLatestVersion(String latestVersion) {
        this.latestVersion = latestVersion;
    }

    public String getMinSupportedVersion() {
        return minSupportedVersion;
    }

    public void setMinSupportedVersion(String minSupportedVersion) {
        this.minSupportedVersion = minSupportedVersion;
    }

    public boolean isUpdateForced() {
        return isUpdateForced;
    }

    public void setUpdateForced(boolean isUpdateForced) {
        this.isUpdateForced = isUpdateForced;
    }

    public String getUpdateUrl() {
        return updateUrl;
    }

    public void setUpdateUrl(String updateUrl) {
        this.updateUrl = updateUrl;
    }

    public String getUpdateMessage() {
        return updateMessage;
    }

    public void setUpdateMessage(String updateMessage) {
        this.updateMessage = updateMessage;
    }
}
