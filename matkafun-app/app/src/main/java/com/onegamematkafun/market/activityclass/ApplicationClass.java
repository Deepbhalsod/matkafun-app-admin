package com.onegamematkafun.market.activityclass; // Replace with your package name

import android.app.Application;

import com.onesignal.Continue;
import com.onesignal.OneSignal;
import com.onesignal.debug.LogLevel;

public class ApplicationClass extends Application {
    @Override
    public void onCreate() {
        super.onCreate();

        // Enable verbose logging for debugging (remove in production)
        OneSignal.getDebug().setLogLevel(LogLevel.VERBOSE);
        // Initialize with your OneSignal App ID
        OneSignal.initWithContext(this, "073624c4-92c2-4807-80d7-4c1744fa381f");
        // Use this method to prompt for push notifications.
        // We recommend removing this method after testing and instead use In-App Messages to prompt for notification permission.
        OneSignal.getNotifications().requestPermission(false, Continue.none());

    }
}