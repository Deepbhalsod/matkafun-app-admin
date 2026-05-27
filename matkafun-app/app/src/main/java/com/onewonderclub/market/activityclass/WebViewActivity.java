package com.onewonderclub.market.activityclass;


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

        String title = getIntent().getStringExtra("TITLE");
        boolean showToolbar = getIntent().getBooleanExtra("SHOW_TOOLBAR", false);

        if (showToolbar) {
            toolbar.setVisibility(View.VISIBLE);
            toolbar.setBackgroundColor(android.graphics.Color.WHITE);
            toolbar.setTitleTextColor(android.graphics.Color.BLACK);

            android.graphics.drawable.Drawable navIcon = androidx.core.content.ContextCompat.getDrawable(this, R.drawable.ic_baseline_arrow_back_24);
            if (navIcon != null) {
                navIcon = androidx.core.graphics.drawable.DrawableCompat.wrap(navIcon);
                androidx.core.graphics.drawable.DrawableCompat.setTint(navIcon, android.graphics.Color.BLACK);
                toolbar.setNavigationIcon(navIcon);
            }

            if (title != null) {
                toolbar.setTitle(title);
            }
            setSupportActionBar(toolbar);
            if (getSupportActionBar() != null) {
                getSupportActionBar().setDisplayHomeAsUpEnabled(true);
                getSupportActionBar().setDisplayShowHomeEnabled(true);
            }
        } else {
            toolbar.setVisibility(View.GONE);
        }



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
        String url = getIntent().getStringExtra("URL");
        if (url == null || url.isEmpty()) {
            url = "about:blank";
        }
        final String finalUrl = url;

        webView.loadUrl(finalUrl);
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                swipeRefreshLayout.setRefreshing(true);
                webView.loadUrl("about:blank");
                webView.loadUrl(finalUrl);
                swipeRefreshLayout.setRefreshing(false);
            }
        });

        webView.setWebViewClient(new WebViewClient(){
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
                return false;
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