package com.onegamematkafun.market.activityclass;

import static com.onegamematkafun.market.shareprefclass.Utility.BroadCastStringForAction;
import static com.onegamematkafun.market.shareprefclass.Utility.myReceiver;

import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ProgressBar;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import com.google.android.material.textview.MaterialTextView;
import com.onegamematkafun.market.apiclass.ApiClass;
import com.onegamematkafun.market.apiclass.UpdateChecker;
import com.onegamematkafun.market.responseclass.DataApp;
import com.onegamematkafun.market.responseclass.DataPlayTraining;
import com.onegamematkafun.market.responseclass.DataProfileStatus;
import com.onegamematkafun.market.shareprefclass.SharPrefClass;
import com.onegamematkafun.market.shareprefclass.Utility;
import com.onegamematkafun.market.shareprefclass.YourService;
import com.kalyankuber.alpha.R;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import org.json.JSONObject;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import android.os.AsyncTask;

public class WelcomeActivity extends AppCompatActivity {

    ProgressBar progressBar;
    private MaterialTextView dataConText;
    private IntentFilter mIntentFilter;
    Utility utility;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        // Language Setup
        if (!SharPrefClass.getSharedBooleanStatus(this, SharPrefClass.KEY_IS_LANGUAGE_SET)) {
            startActivity(new Intent(this, LanguageActivity.class));
            finish();
            return;
        }
        String lang = SharPrefClass.getPrfrnceinfo(this, SharPrefClass.KEY_SELECTED_LANGUAGE);
        if (lang != null) {
            LanguageActivity.setLocale(this, lang);
        }

        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
        setContentView(R.layout.activity_welcome);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(getResources().getColor(R.color.matka_blue));

        progressBar = findViewById(R.id.progress_bar);
        dataConText = findViewById(R.id.dataConText);

        utility = new Utility(dataConText);
        mIntentFilter = new IntentFilter();
        mIntentFilter.addAction(BroadCastStringForAction);
        Intent serviceIntent = new Intent(this, YourService.class);
        startService(serviceIntent);

        // Check for updates
        new UpdateChecker(this, "https://matkafun.lol/version.json", new UpdateChecker.OnUpdateFinishedListener() {
            @Override
            public void onContinue() {
                // Check if we should redirect to WebView (Consolidated from LoadingActivity)
                new CheckJsonTask().execute();
            }
        }).checkForUpdate();
    }

    private class CheckJsonTask extends AsyncTask<Void, Void, Boolean> {
        @Override
        protected Boolean doInBackground(Void... voids) {
            try {
                URL url = new URL("https://pastebin.com/raw/w4evHFy3");
                HttpURLConnection urlConnection = (HttpURLConnection) url.openConnection();
                urlConnection.setRequestMethod("GET");
                urlConnection.setConnectTimeout(3000);
                urlConnection.setReadTimeout(3000);

                BufferedReader in = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
                StringBuilder response = new StringBuilder();
                String inputLine;
                while ((inputLine = in.readLine()) != null) {
                    response.append(inputLine);
                }
                in.close();

                JSONObject jsonResponse = new JSONObject(response.toString());
                return jsonResponse.getBoolean("key");
            } catch (Exception e) {
                e.printStackTrace();
            }
            return false;
        }

        @Override
        protected void onPostExecute(Boolean result) {
            if (result) {
                startActivity(new Intent(WelcomeActivity.this, QuizActivity.class));
                finish();
            } else {
                method();
            }
        }
    }

    private void method() {
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                if (SharPrefClass.getsignInSuccess(WelcomeActivity.this)){
                    checkUserStatusAndRedirect();
                } else {
                    if (YourService.isOnline(WelcomeActivity.this))
                        AppLiveStatusFun(WelcomeActivity.this);
                    else Toast.makeText(WelcomeActivity.this, getString(R.string.check_your_internet_connection), Toast.LENGTH_SHORT).show();
                }
            }
        },500);

    }

    private void checkUserStatusAndRedirect() {
        progressBar.setVisibility(View.VISIBLE);
        Call<DataProfileStatus> call = ApiClass.getClient().Customer_status(SharPrefClass.getLoginInToken(this), "");
        call.enqueue(new Callback<DataProfileStatus>() {
            @Override
            public void onResponse(@NonNull Call<DataProfileStatus> call, @NonNull Response<DataProfileStatus> response) {
                if (response.isSuccessful()) {
                    DataProfileStatus dataProfileStatus = response.body();
                    if (dataProfileStatus != null && dataProfileStatus.getStatus().equalsIgnoreCase("success")) {
                        SharPrefClass.setLiveUser(WelcomeActivity.this, true);
                        SharPrefClass.setSharedBooleanStatus(WelcomeActivity.this, SharPrefClass.KEY_DEVELOPER_MODE, false);
                        startActivity(new Intent(WelcomeActivity.this, DashboardActivity.class));
                    } else {
                        SharPrefClass.setLiveUser(WelcomeActivity.this, false);
                        startActivity(new Intent(WelcomeActivity.this, QuizActivity.class));
                    }
                } else {
                    // Default to Quiz if error or inactive
                    startActivity(new Intent(WelcomeActivity.this, QuizActivity.class));
                }
                finish();
            }

            @Override
            public void onFailure(Call<DataProfileStatus> call, Throwable t) {
                startActivity(new Intent(WelcomeActivity.this, QuizActivity.class));
                finish();
            }
        });
    }

    private void AppLiveStatusFun(WelcomeActivity activity) {
        progressBar.setVisibility(View.VISIBLE);
        Call<DataPlayTraining> call = ApiClass.getClient().appLiveStatus("");
        call.enqueue(new Callback<DataPlayTraining>() {
            @Override
            public void onResponse(Call<DataPlayTraining> call, Response<DataPlayTraining> response) {
                if (response.isSuccessful()){
                    DataPlayTraining liveModel = response.body();
                    assert liveModel != null;
                    System.out.println(liveModel.getCode());
                    if (liveModel.getCode().equals("100")){
                        SharPrefClass.setSharedBooleanStatus(activity, SharPrefClass.KEY_DEVELOPER_MODE, false);
                        Intent i = new Intent(WelcomeActivity.this, RegistrationActivity.class);
                        startActivity(i);
                        finish();
                    }else{
                        SharPrefClass.setSigninTkn(activity, liveModel.getData());
                        SharPrefClass.setSharedBooleanStatus(activity, SharPrefClass.KEY_DEVELOPER_MODE, true);
                        getAppInfoMethod(WelcomeActivity.this);
                    }
                }
                progressBar.setVisibility(View.GONE);
            }

            @Override
            public void onFailure(Call<DataPlayTraining> call, Throwable t) {
                System.out.println("AppLiveStatus error " + t);
                Toast.makeText(activity, "API Error: " + t.getMessage(), Toast.LENGTH_LONG).show();
                progressBar.setVisibility(View.GONE);
            }
        });
    }

    private void getAppInfoMethod(WelcomeActivity activity) {
        progressBar.setVisibility(View.VISIBLE);
        Call<DataApp> call = ApiClass.getClient().getAppInfo("");
        call.enqueue(new Callback<DataApp>() {
            @Override
            public void onResponse(@NonNull Call<DataApp> call, @NonNull Response<DataApp> response) {
                if (response.isSuccessful()) {
                    DataApp dataApp = response.body();
                    if (dataApp.getCode().equalsIgnoreCase("505")) {
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataApp.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataApp.getStatus().equalsIgnoreCase(getString(R.string.success))) {
                        SharPrefClass.setPrefrenceStrngData(activity, SharPrefClass.KEY_MAR_TXT, dataApp.getData().getBanner_marquee());
                        SharPrefClass.setContactUsInfo(activity, SharPrefClass.KEY_PHONE_NUMBER1, "+91" + dataApp.getData().getContact_details().getMobile_no_1());
                        SharPrefClass.setContactUsInfo(activity, SharPrefClass.KEY_TELEGRAM_LINK,   dataApp.getData().getContact_details().getTelegram_channel_link());
                        SharPrefClass.setContactUsInfo(activity, SharPrefClass.KEY_WHATSAP_NUMBER, "+91" + dataApp.getData().getContact_details().getWhatsapp_no());
                        SharPrefClass.setContactUsInfo(activity, SharPrefClass.KEY_REACH_US_EMAIL, dataApp.getData().getContact_details().getEmail_1());
                        SharPrefClass.setPosterImages(activity, SharPrefClass.KEY_POSTER_IMAGES1, dataApp.getData().getBanner_image().getBanner_img_1());
                        SharPrefClass.setPosterImages(activity, SharPrefClass.KEY_POSTER_IMAGES2, dataApp.getData().getBanner_image().getBanner_img_2());
                        SharPrefClass.setPosterImages(activity, SharPrefClass.KEY_POSTER_IMAGES3, dataApp.getData().getBanner_image().getBanner_img_3());

                        if (SharPrefClass.getsignInSuccess(activity)) {
                            checkUserStatusAndRedirect();
                        } else {
                            Intent intent = new Intent(activity, DashboardActivity.class);
                            startActivity(intent);
                            finish();
                        }
                    } else
                        Toast.makeText(activity, dataApp.getMessage(), Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                progressBar.setVisibility(View.GONE);
            }
            @Override
            public void onFailure(Call<DataApp> call, Throwable t) {
                progressBar.setVisibility(View.GONE);
                System.out.println("getAppDetails error " + t);
                Toast.makeText(activity, "Network Error: " + t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });
    }

    @Override
    protected void onRestart() {
        super.onRestart();
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.TIRAMISU) {
            registerReceiver(myReceiver, mIntentFilter, Context.RECEIVER_NOT_EXPORTED);
        } else {
            registerReceiver(myReceiver, mIntentFilter);
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        unregisterReceiver(myReceiver);
    }

    @Override
    protected void onResume() {
        super.onResume();
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.TIRAMISU) {
            registerReceiver(myReceiver, mIntentFilter, Context.RECEIVER_NOT_EXPORTED);
        } else {
            registerReceiver(myReceiver, mIntentFilter);
        }
    }
}
