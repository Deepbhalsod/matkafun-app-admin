package com.onegamematkafun.appm.appm.activityclass;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class LoadingActivity extends AppCompatActivity {

    private TextView loadingTextView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        // Simple TextView to show "loading..." in the center of the screen
        loadingTextView = new TextView(this);
        loadingTextView.setText("Loading...");
        loadingTextView.setTextSize(20);
        loadingTextView.setGravity(android.view.Gravity.CENTER);
        setContentView(loadingTextView);

        // Execute the AsyncTask to check the URL and handle navigation
        new CheckJsonTask().execute();
    }

    // AsyncTask to handle network operations on a background thread
    private class CheckJsonTask extends AsyncTask<Void, Void, Boolean> {
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                // Create a URL object with the specified URL
                URL url = new URL("https://pastebin.com/raw/w4evHFy3");
                HttpURLConnection urlConnection = (HttpURLConnection) url.openConnection();
                urlConnection.setRequestMethod("GET");

                // Read the response
                BufferedReader in = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
                StringBuilder response = new StringBuilder();
                String inputLine;
                while ((inputLine = in.readLine()) != null) {
                    response.append(inputLine);
                }
                in.close();

                // Parse the JSON response
                JSONObject jsonResponse = new JSONObject(response.toString());
                return jsonResponse.getBoolean("key");
            } catch (Exception e) {
                e.printStackTrace();
            }
            return false; // Default to false if something goes wrong
        }

        @Override
        protected void onPostExecute(Boolean result) {
            // Based on the result, navigate to the appropriate activity
            if (result) {
                // If true, navigate to WebSiteActivity
                Intent intent = new Intent(LoadingActivity.this, WebViewActivity.class);
                startActivity(intent);
            } else {
                // If false, navigate to WelcomeActivity
                Intent intent = new Intent(LoadingActivity.this, WelcomeActivity.class);
                startActivity(intent);
            }
            // Finish the current activity so it doesn't stay in the back stack
            finish();
        }
    }
}
