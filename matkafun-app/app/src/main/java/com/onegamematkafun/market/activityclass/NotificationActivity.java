package com.onegamematkafun.market.activityclass;

import android.os.Bundle;
import android.widget.ListView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import com.google.android.material.appbar.MaterialToolbar;
import com.kalyankuber.alpha.R;
import org.json.JSONArray;
import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import com.onegamematkafun.market.responseclass.DataNotification;
import java.util.ArrayList;

public class NotificationActivity extends AppCompatActivity {

    ListView listView;
    ArrayList<DataNotification> noticeList = new ArrayList<>();
    NotificationAdapter adapter; // Custom adapter with icon

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notification);

        // ✅ Toolbar back button handling
        MaterialToolbar toolbar = findViewById(R.id.toolbar);
        toolbar.setNavigationOnClickListener(v -> onBackPressed());

        listView = findViewById(R.id.listView);
        adapter = new NotificationAdapter(this, noticeList);
        listView.setAdapter(adapter);

        fetchNotices();
    }

    private void fetchNotices() {
        new Thread(() -> {
            try {
                // ✅ Replace with your actual live PHP file URL
                URL url = new URL("https://matkafun.fun/get_notifications.php");
                HttpURLConnection conn = (HttpURLConnection) url.openConnection();
                conn.setRequestMethod("GET");
                conn.setConnectTimeout(10000);
                conn.setReadTimeout(10000);

                BufferedReader in = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                StringBuilder result = new StringBuilder();
                String line;
                while ((line = in.readLine()) != null) result.append(line);
                in.close();

                JSONArray jsonArray = new JSONArray(result.toString());
                noticeList.clear();
                for (int i = 0; i < jsonArray.length(); i++) {
                    JSONObject obj = jsonArray.getJSONObject(i);
                    String title = "";
                    
                    // Prioritize 'heading' and 'title' from our updated PHP, but check others for safety
                    if (obj.has("heading") && !obj.optString("heading").equalsIgnoreCase("null")) {
                        title = obj.optString("heading");
                    } else if (obj.has("title") && !obj.optString("title").equalsIgnoreCase("null")) {
                        title = obj.optString("title");
                    } else if (obj.has("Heading")) {
                        title = obj.optString("Heading");
                    }

                    // Fallback to a better default if still empty
                    if (title == null || title.trim().isEmpty()) {
                        title = "Royal Group Notification";
                    }
                    
                    String message = obj.optString("message", "");
                    String time = obj.optString("created_date", obj.optString("time", obj.optString("created_at", "")));

                    // Fix spacing for result notifications (e.g., Open468-8 -> Open 468-8)
                    if (message.startsWith("Open") && message.length() > 4 && Character.isDigit(message.charAt(4))) {
                        message = "Open " + message.substring(4);
                    } else if (message.startsWith("Close") && message.length() > 5 && Character.isDigit(message.charAt(5))) {
                        message = "Close " + message.substring(5);
                    }
                    
                    noticeList.add(new DataNotification(title, message, time));
                }

                runOnUiThread(() -> adapter.notifyDataSetChanged());

            } catch (Exception e) {
                e.printStackTrace();
                runOnUiThread(() ->
                        Toast.makeText(NotificationActivity.this, "Failed to load notifications", Toast.LENGTH_SHORT).show());
            }
        }).start();
    }
}
