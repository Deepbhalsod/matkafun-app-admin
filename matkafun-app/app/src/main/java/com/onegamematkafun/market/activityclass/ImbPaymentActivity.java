package com.onegamematkafun.market.activityclass;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.WebChromeClient;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ProgressBar;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.kalyankuber.alpha.R;

public class ImbPaymentActivity extends AppCompatActivity {

    private static final String TAG = "ImbPaymentActivity";

    private WebView webView;
    private ProgressBar progressBar;

    private String paymentUrl;
    private String amount;
    private String orderId;

    private boolean finishedOnce = false;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_imb_payment);

        webView = findViewById(R.id.webview);
        progressBar = findViewById(R.id.progressBar);

        paymentUrl = getIntent().getStringExtra("payment_url");
        amount = getIntent().getStringExtra("amount");
        orderId = getIntent().getStringExtra("order_id");

        if (paymentUrl == null) {
            finish();
            return;
        }

        setupWebView();
        webView.loadUrl(paymentUrl);
    }

    private void setupWebView() {

        WebSettings settings = webView.getSettings();
        settings.setJavaScriptEnabled(true);
        settings.setDomStorageEnabled(true);
        settings.setUseWideViewPort(true);
        settings.setLoadWithOverviewMode(true);
        settings.setSupportZoom(false);

        webView.setWebChromeClient(new WebChromeClient());

        webView.setWebViewClient(new WebViewClient() {

            @Override
            public void onPageStarted(WebView view, String url, Bitmap favicon) {
                progressBar.setVisibility(View.VISIBLE);
                Log.d(TAG, "Loading: " + url);
                super.onPageStarted(view, url, favicon);
            }

            @Override
            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {

                String newUrl = request.getUrl().toString();
                Log.d(TAG, "Redirect: " + newUrl);

                // ✅ UPI open external
                if (newUrl.startsWith("upi:") ||
                        newUrl.startsWith("paytmmp:") ||
                        newUrl.startsWith("phonepe:") ||
                        newUrl.startsWith("gpay:") ||
                        newUrl.startsWith("intent:")) {

                    try {
                        Intent intent = Intent.parseUri(newUrl, Intent.URI_INTENT_SCHEME);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        startActivity(intent);
                    } catch (Exception e) {
                        Log.e(TAG, "UPI error: " + e.getMessage());
                    }
                    return true;
                }

                handleUrl(newUrl);
                view.loadUrl(newUrl);
                return true;
            }
        });
    }

    private void handleUrl(String url) {

        if (finishedOnce) return;

        String lower = url.toLowerCase();
        Log.d(TAG, "Checking URL: " + lower);

        // ✅ SUCCESS
        if (lower.contains("matkafun.lol/succes.php")) {

            finishedOnce = true;

            Intent result = new Intent();
            result.putExtra("success", true);
            result.putExtra("amount", amount);
            result.putExtra("order_id", orderId);

            setResult(Activity.RESULT_OK, result);
            finish();
            return;
        }

        // ❌ FAIL
        if (lower.contains("fail") || lower.contains("failed") || lower.contains("cancel")) {

            finishedOnce = true;

            Intent result = new Intent();
            result.putExtra("success", false);

            setResult(Activity.RESULT_CANCELED, result);
            finish();
        }
    }

    @Override
    public void onBackPressed() {

        if (!finishedOnce) {
            Intent result = new Intent();
            result.putExtra("success", false);
            setResult(Activity.RESULT_CANCELED, result);
        }

        finish();
    }
}