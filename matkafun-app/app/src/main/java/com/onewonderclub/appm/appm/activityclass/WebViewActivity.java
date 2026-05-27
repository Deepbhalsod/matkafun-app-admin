package com.onewonderclub.appm.appm.activityclass;


import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.appbar.MaterialToolbar;
import com.kalyankuber.alpha.R;

public class WebViewActivity extends AppCompatActivity {

    public static SwipeRefreshLayout swipeRefreshLayout;
    private MaterialToolbar toolbar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_web_site);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(getResources().getColor(R.color.matka_blue));
        //         toolbar.setBackgroundColor(Color.parseColor("#1E88E5"));

        swipeRefreshLayout = findViewById(R.id.swipe_refresh_layout);
        swipeRefreshLayout.setColorSchemeColors(getResources().getColor(R.color.matka_blue),getResources().getColor(R.color.matka_darkblue),getResources().getColor(R.color.matka_darkblue));

        toolbar = findViewById(R.id.toolbar);
        toolbar.setVisibility(View.GONE);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
        TextView backButton = findViewById(R.id.backbtn);
        backButton.setVisibility(View.GONE);



        WebView webView = findViewById(R.id.web); // Enable JavaScript
        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);

        // Enable DOM storage (required for some HTML5 games)
        webSettings.setDomStorageEnabled(true);

        webSettings.setCacheMode(WebSettings.LOAD_DEFAULT);

        // Enable database storage (required for some HTML5 features)
        webSettings.setDatabaseEnabled(true);

        // Enable media playback (if your game has sound or video)
        webSettings.setMediaPlaybackRequiresUserGesture(false);
        webView.setFocusableInTouchMode(false);
        webView.setFocusable(false);
        webView.loadUrl("about:blank");
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipeRefreshLayout.setRefreshing(true);
                webView.loadUrl("about:blank");
                swipeRefreshLayout.setRefreshing(false);
            }
        });

        webView.setWebViewClient(new WebViewClient(){
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
                return true;
            }
        });
    }

    public void GoBack(View view) {
        finish();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == android.R.id.home){
            finish();
            return true;
        }
        return true;
    }
}