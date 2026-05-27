package com.onewonderclub.market.activityclass;

import static com.onewonderclub.market.shareprefclass.Utility.BroadCastStringForAction;
import static com.onewonderclub.market.shareprefclass.Utility.myReceiver;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.Uri;
import android.os.Bundle;
import android.text.TextUtils;
import android.text.method.PasswordTransformationMethod;
import android.text.method.SingleLineTransformationMethod;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.snackbar.Snackbar;
import com.google.android.material.textfield.TextInputEditText;
import com.google.android.material.textview.MaterialTextView;
import com.onewonderclub.market.apiclass.ApiClass;
import com.onewonderclub.market.responseclass.DataLogIN;
import com.onewonderclub.market.responseclass.DataProfileStatus;
import com.onewonderclub.market.shareprefclass.SharPrefClass;
import com.onewonderclub.market.shareprefclass.Utility;
import com.onewonderclub.market.shareprefclass.YourService;
import com.kalyankuber.alpha.R;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SignInActivity extends AppCompatActivity {

    private TextInputEditText inNum, inPass;
    private ShapeableImageView pToggle;
    private ProgressBar progressBar;
    private MaterialTextView mDataConText;
    private IntentFilter mIntentFilter;
    Utility utility;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_in);
        intVariables();
        loadData();
        LinearLayout contactUsLayout = findViewById(R.id.contact_us_layout);

        // Set OnClickListener on the LinearLayout
        contactUsLayout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ContactUs(); // Call the ContactUs method
            }
        });

    }

    private void loadData() {
        utility = new Utility(mDataConText);
        mIntentFilter = new IntentFilter();
        mIntentFilter.addAction(BroadCastStringForAction);
        Intent serviceIntent = new Intent(this, YourService.class);
        startService(serviceIntent);
    }

    public void SignInBtn(View view) {
        InputMethodManager inputMethodManager = (InputMethodManager) getSystemService(Activity.INPUT_METHOD_SERVICE);
        inputMethodManager.hideSoftInputFromWindow(view.getWindowToken(), 0);
        String number = inNum.getText().toString();
        String password = inPass.getText().toString();
        if (TextUtils.isEmpty(number)){
            Snackbar.make(view, getString(R.string.please_enter_mobile_number),2000).show();
            return;
        }
        if (number.length()!=10){
            Snackbar.make(view, getString(R.string.please_enter_valid_mobile_number),2000).show();
            return;
        }
        if (TextUtils.isEmpty(password)){
            Snackbar.make(view, getString(R.string.please_enter_password),2000).show();
            return;
        }
        if (password.length()<4){
            Snackbar.make(view, getString(R.string.please_enter_min_4_digits_password),2000).show();
            return;
        }
        if (YourService.isOnline(this))
            signInMethod(number,password);
        else Toast.makeText(this, getString(R.string.check_your_internet_connection), Toast.LENGTH_SHORT).show();


    }


    private void signInMethod(String number, String password) {
        progressBar.setVisibility(View.VISIBLE);
        Call<DataLogIN> call = ApiClass.getClient().getSignIn(number, password);
        call.enqueue(new Callback<DataLogIN>() {
            @Override
            public void onResponse(@NonNull Call<DataLogIN> call, @NonNull Response<DataLogIN> response) {
                if (response.isSuccessful()){
                    DataLogIN dataLogIN = response.body();
                    assert dataLogIN != null;
                    if (dataLogIN.getStatus().equals("success")){
                        SharPrefClass.setSigninTkn(SignInActivity.this, dataLogIN.getData().getToken());
                        SharPrefClass.setSigninSuccess(SignInActivity.this, true);
                        checkUserStatusAndRedirect(dataLogIN.getData().getToken());
                    }else{
                        Toast.makeText(SignInActivity.this, dataLogIN.getMessage(), Toast.LENGTH_SHORT).show();
                    }

                }else {
                    Toast.makeText(SignInActivity.this, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                progressBar.setVisibility(View.GONE);
            }
            @Override
            public void onFailure(Call<DataLogIN> call, Throwable t) {
                Toast.makeText(getApplicationContext(), getString(R.string.on_api_failure), Toast.LENGTH_LONG).show();
                System.out.println("getSignUp OnFailure "+t);
                progressBar.setVisibility(View.GONE);
            }
        });
    }
    
    private void checkUserStatusAndRedirect(String token) {
        progressBar.setVisibility(View.VISIBLE);
        Call<DataProfileStatus> call = ApiClass.getClient().Customer_status(token, "");
        call.enqueue(new Callback<DataProfileStatus>() {
            @Override
            public void onResponse(@NonNull Call<DataProfileStatus> call, @NonNull Response<DataProfileStatus> response) {
                if (response.isSuccessful()) {
                    DataProfileStatus dataProfileStatus = response.body();
                    if (dataProfileStatus != null && dataProfileStatus.getStatus().equalsIgnoreCase("success")) {
                        SharPrefClass.setLiveUser(SignInActivity.this, true);
                        SharPrefClass.setSharedBooleanStatus(SignInActivity.this, SharPrefClass.KEY_DEVELOPER_MODE, false);
                        startActivity(new Intent(SignInActivity.this, DashboardActivity.class));
                    } else {
                        SharPrefClass.setLiveUser(SignInActivity.this, false);
                        startActivity(new Intent(SignInActivity.this, QuizActivity.class));
                    }
                } else {
                    // Default to Quiz if error or inactive
                    startActivity(new Intent(SignInActivity.this, QuizActivity.class));
                }
                finish();
            }

            @Override
            public void onFailure(Call<DataProfileStatus> call, Throwable t) {
                startActivity(new Intent(SignInActivity.this, QuizActivity.class));
                finish();
            }
        });
    }

    public void passToggle(View view) {
        if (inPass.getTransformationMethod().getClass().getSimpleName() .equals("PasswordTransformationMethod")) {
            inPass.setTransformationMethod(new SingleLineTransformationMethod());
            pToggle.setImageResource(R.drawable.ic_baseline_visibility_off_24);
        }
        else {
            inPass.setTransformationMethod(new PasswordTransformationMethod());
            pToggle.setImageResource(R.drawable.ic_baseline_visibility_24);
        }

        inPass.setSelection(inPass.getText().length());
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
    public void forPass(View view) {
        try {
            // Get WhatsApp number from SharedPreferences
            String whatsappNumber = SharPrefClass.getContactObject(this, SharPrefClass.KEY_WHATSAP_NUMBER);

            if (whatsappNumber == null || whatsappNumber.isEmpty()) {
                Toast.makeText(this, "WhatsApp number not found.", Toast.LENGTH_SHORT).show();
                return;
            }

            // Remove '+' if included
            if (whatsappNumber.startsWith("+")) {
                whatsappNumber = whatsappNumber.substring(1);
            }

            // Specific message for forgot password
            String msg = "Hello Admin, I forgot my password. Please help me recover it.";
            
            // Append phone number if available
            if (!TextUtils.isEmpty(inNum.getText().toString())){
                msg += "\nMy Registered Phone Number: " + inNum.getText().toString();
            }

            // Create WhatsApp link dynamically
            String whatsappLink = "https://wa.me/" + whatsappNumber + "?text=" + Uri.encode(msg);

            // Create intent and open WhatsApp
            Intent whatsappIntent = new Intent(Intent.ACTION_VIEW);
            whatsappIntent.setData(Uri.parse(whatsappLink));
            whatsappIntent.setPackage("com.whatsapp"); // ensures it opens directly in WhatsApp
            startActivity(whatsappIntent);

        } catch (Exception e) {
            Toast.makeText(this, "Unable to open WhatsApp.", Toast.LENGTH_SHORT).show();
            e.printStackTrace();
        }
    }

    private void ContactUs() {
        try {
            // Get WhatsApp number from SharedPreferences
            String whatsappNumber = SharPrefClass.getContactObject(this, SharPrefClass.KEY_WHATSAP_NUMBER);

            if (whatsappNumber == null || whatsappNumber.isEmpty()) {
                Toast.makeText(this, "WhatsApp number not found.", Toast.LENGTH_SHORT).show();
                return;
            }

            // Remove '+' if included
            if (whatsappNumber.startsWith("+")) {
                whatsappNumber = whatsappNumber.substring(1);
            }

            // Optional prefilled message
            String msg = "Hello Sir, I need some help regarding my account.";

            // Create WhatsApp link dynamically
            String whatsappLink = "https://wa.me/" + whatsappNumber + "?text=" + Uri.encode(msg);

            // Create intent and open WhatsApp
            Intent whatsappIntent = new Intent(Intent.ACTION_VIEW);
            whatsappIntent.setData(Uri.parse(whatsappLink));
            whatsappIntent.setPackage("com.whatsapp"); // ensures it opens directly in WhatsApp
            startActivity(whatsappIntent);

        } catch (Exception e) {
            Toast.makeText(this, "Unable to open WhatsApp.", Toast.LENGTH_SHORT).show();
            e.printStackTrace();
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

private void intVariables() {
        inNum = findViewById(R.id.phone_num);
        inPass = findViewById(R.id.in_pass);
        pToggle = findViewById(R.id.pass_toggle);
        progressBar = findViewById(R.id.progressBar);
        mDataConText = findViewById(R.id.dataConText);
    }

    public void registerClick(View view) {
        Intent intent = new Intent(this, RegistrationActivity.class);
        startActivity(intent);
    }

    @Override
    public void onBackPressed() {
        finishAffinity();
    }


}