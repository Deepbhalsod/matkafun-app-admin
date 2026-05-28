package com.onegamematkafun.market.activityclass;

import static com.onegamematkafun.market.fragment.DashboardFragment.user_name;
import static com.onegamematkafun.market.fragment.StarlineFragment.dobPV;
import static com.onegamematkafun.market.fragment.StarlineFragment.sinDV;
import static com.onegamematkafun.market.fragment.StarlineFragment.sinPV;
import static com.onegamematkafun.market.fragment.StarlineFragment.starlineRatesList;
import static com.onegamematkafun.market.fragment.StarlineFragment.triPV;
import static com.onegamematkafun.market.fragment.WalletFragment.mMinWithdCoins;
import static com.onegamematkafun.market.fragment.WalletFragment.mWithdCT;
import static com.onegamematkafun.market.fragment.WalletFragment.mWithdOT;
import static com.onegamematkafun.market.shareprefclass.Utility.BroadCastStringForAction;
import static com.onegamematkafun.market.shareprefclass.Utility.myReceiver;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.graphics.Color;
import org.json.JSONObject;

import android.graphics.Typeface;
import android.os.Bundle;
import android.text.SpannableString;
import android.text.style.ForegroundColorSpan;
import android.text.style.RelativeSizeSpan;
import android.text.style.StyleSpan;
import android.view.Gravity;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationView;
import com.google.android.material.switchmaterial.SwitchMaterial;
import com.google.android.material.tabs.TabLayout;
import com.google.android.material.textview.MaterialTextView;
import com.onegamematkafun.market.adapterclass.NonSwipeableViewPager;
import com.onegamematkafun.market.adapterclass.ViewPagerAppliance;
import com.onegamematkafun.market.apiclass.ApiClass;
import com.onegamematkafun.market.fragment.ChartFragment;
import com.onegamematkafun.market.fragment.DashboardFragment;
import com.onegamematkafun.market.fragment.StarlineFragment;
import com.onegamematkafun.market.fragment.WalletFragment;
import com.onegamematkafun.market.responseclass.DataGameList;
import com.onegamematkafun.market.responseclass.DataLogIN;
import com.onegamematkafun.market.responseclass.DataProfileStatus;
import com.onegamematkafun.market.responseclass.DataStarlineGameList;
import com.onegamematkafun.market.responseclass.DataWalletHistory;
import com.onegamematkafun.market.shareprefclass.SharPrefClass;
import com.onegamematkafun.market.responseclass.DataApp;
import com.onegamematkafun.market.shareprefclass.Utility;
import com.onegamematkafun.market.shareprefclass.YourService;
import com.kalyankuber.alpha.R;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DashboardActivity extends AppCompatActivity {

    private MaterialToolbar mToolbar;
    private NavigationView mNaviView;
    private DrawerLayout mDrawerLayout;
    public static MaterialTextView userName, mMobileNum;
    private MenuItem purse, mBankAc, mpurseMenu, howToLearn, mGameValues, mCoins,  profile, contactUs,changePassword, logout;
    private ProgressBar mProgressBar;
    private SwipeRefreshLayout refreshLayout;
    private int mAvaPoints =0;
    private SwitchMaterial mNotiSwitchBtn;
//    private RelativeLayout walletIconLayout, notificationIconLayout;
//    private TextView walletCountBadge;
//    private SwitchMaterial toolbarNotiSwitch;
    private MaterialTextView mDataConText;
    private IntentFilter mIntentFilter;
    public static NonSwipeableViewPager viewPager;
    private ViewPagerAppliance viewPagerAppliance;
    private TabLayout tabLayout;
    private RelativeLayout progressOverlay;
    private BottomNavigationView bottomNavigationView;
    private TextView mWalletBalanceText;
    private View mMenuPill, mWalletPill, mNotificationIcon;
    private TextView notificationBadge;

    @SuppressLint("SimpleDateFormat")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(ContextCompat.getColor(this, R.color.white));
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.M) {
            window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR);
        }
        
        String lang = SharPrefClass.getPrfrnceinfo(this, SharPrefClass.KEY_SELECTED_LANGUAGE);
        if (lang != null) {
            LanguageActivity.setLocale(this, lang);
        }

        SharPrefClass.setPreferenceBooleanData(this, "noticeShown", false);

        // Initialize the ProgressOverlay
        progressOverlay = findViewById(R.id.progressOverlay);

        // Example: Show full-screen loader when an activity starts
        showFullScreenLoader();



        intVariables();
        updateUserStatus();
        confToolbar();
        confiData();
        clickListener();
        confiViewPager();


        Utility utility = new Utility(mDataConText);
        mIntentFilter = new IntentFilter();
        mIntentFilter.addAction(BroadCastStringForAction);
        Intent serviceIntent = new Intent(this, YourService.class);
        startService(serviceIntent);


        if (!SharPrefClass.getSharedBooleanStatus(this, "noticeShown")) {
            fetchNoticeFromServer();
        }
        getAppInfoMethod();

        bottomNavigationView.setSelectedItemId(R.id.nav_home);
    }

    // Replace fetchNoticeFromServer() with this improved version
    private void fetchNoticeFromServer() {
        final String url = "https://wonder1club.click/notice.php";

        new Thread(() -> {
            java.net.HttpURLConnection conn = null;
            java.io.InputStream inputStream = null;
            try {
                java.net.URL noticeUrl = new java.net.URL(url);
                conn = (java.net.HttpURLConnection) noticeUrl.openConnection();
                conn.setRequestMethod("GET");
                conn.setConnectTimeout(8000);
                conn.setReadTimeout(8000);
                conn.connect();

                int responseCode = conn.getResponseCode();
                if (responseCode == java.net.HttpURLConnection.HTTP_OK) {
                    inputStream = conn.getInputStream();
                    java.util.Scanner scanner = new java.util.Scanner(inputStream).useDelimiter("\\A");
                    String response = scanner.hasNext() ? scanner.next() : "";

                    JSONObject obj = new JSONObject(response);
                    String noticeText = obj.optString("notice", "").trim();

                    // ✅ Show popup ONLY when notice text is available
                    if (!noticeText.isEmpty()) {
                        runOnUiThread(() -> {
                            if (!isFinishing() && !isDestroyed()) {
                                showNoticeDialog(noticeText);
                            }
                        });
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
            } finally {
                try { if (inputStream != null) inputStream.close(); } catch (Exception ignored) {}
                if (conn != null) conn.disconnect();
            }
        }).start();
    }

    // small helper to ensure activity is safe to show a dialog
    private boolean isActivityAliveForDialog() {
        if (isFinishing()) return false;
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.JELLY_BEAN_MR1) {
            if (isDestroyed()) return false;
        }
        return true; // remove the isActive check for now
    }

    // Replace showNoticeDialog(...) with this safer version
    private void showNoticeDialog(String noticeText) {
        try {
            AlertDialog.Builder builder = new AlertDialog.Builder(this, R.style.CustomDialogTheme);
            View view = getLayoutInflater().inflate(R.layout.dialog_notice, null);
            builder.setView(view);
            final AlertDialog dialog = builder.create();

            MaterialTextView noticeTitle = view.findViewById(R.id.noticeTitle);
            MaterialTextView noticeMessage = view.findViewById(R.id.noticeMessage);
            MaterialTextView okButton = view.findViewById(R.id.okButton);

            noticeTitle.setText("📢 Notice");
            noticeMessage.setText(noticeText);

            okButton.setOnClickListener(v -> {
                try {
                    dialog.dismiss();
                } catch (Exception ignored) {}
                SharPrefClass.setPreferenceBooleanData(this, "noticeShown", true);
            });

            dialog.show();
            dialog.getWindow().setBackgroundDrawable(
                    ContextCompat.getDrawable(this, R.drawable.rounded_corner_white)
            );

            // Center + proper width
            dialog.getWindow().setGravity(Gravity.CENTER);
            WindowManager.LayoutParams params = new WindowManager.LayoutParams();
            params.copyFrom(dialog.getWindow().getAttributes());
            params.width = (int) (getResources().getDisplayMetrics().widthPixels * 0.85);
            params.height = WindowManager.LayoutParams.WRAP_CONTENT;
            dialog.getWindow().setAttributes(params);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }


    private void showFullScreenLoader() {
        if (progressOverlay != null) {
            progressOverlay.setVisibility(View.VISIBLE);  // Make the full-screen overlay visible
        }
    }

    // Method to hide the full-screen loader
    private void hideFullScreenLoader() {
        if (progressOverlay != null) {
            progressOverlay.setVisibility(View.GONE);  // Hide the full-screen overlay
        }
    }

    private void confiViewPager() {
        viewPagerAppliance.add(new DashboardFragment(),"Dashboard");
        viewPagerAppliance.add(new StarlineFragment(), "StarLine");
        viewPagerAppliance.add(new WalletFragment(), "Wallet");
        viewPagerAppliance.add(new ChartFragment(), "Chart");
        viewPager.setAdapter(viewPagerAppliance);
        tabLayout.setupWithViewPager(viewPager);
    }

    private void clickListener() {                getTurnamentList(DashboardActivity.this);

        refreshLayout.setOnRefreshListener(() -> {
            if (YourService.isOnline(DashboardActivity.this)){
                checkUserStatusMethod();
                getGameListMethod(DashboardActivity.this);
                getDesawarGame(DashboardActivity.this);
                purseStatementMethod(DashboardActivity.this);
                getUserInfoMethod(DashboardActivity.this, SharPrefClass.getLoginInToken(DashboardActivity.this));
            }
            else Toast.makeText(DashboardActivity.this, "Check Your Internet Connection", Toast.LENGTH_SHORT).show();
        });
        mNotiSwitchBtn.setOnCheckedChangeListener((buttonView, isChecked) -> SharPrefClass.setBinalData(DashboardActivity.this, SharPrefClass.KEY_FIREBSE_ALLOW, isChecked));

        mToolbar.setOnMenuItemClickListener(item -> {
            switch (item.getItemId()) {
                case R.id.purse:
                case R.id.coins:
                    viewPager.setCurrentItem(2, true);
                    return true;

                case R.id.notification:
                    Intent notiIntent = new Intent(DashboardActivity.this, NotificationActivity.class);
                    startActivity(notiIntent);
                    return true;

                default:
                    return false;
            }
        });

/*        walletIconLayout.setOnClickListener(v -> {
            viewPager.setCurrentItem(2, true);
        });

        notificationIconLayout.setOnClickListener(v -> {
            Intent notiIntent = new Intent(DashboardActivity.this, NotificationActivity.class);
            startActivity(notiIntent);
        });

        toolbarNotiSwitch.setOnCheckedChangeListener((buttonView, isChecked) -> {
            SharPrefClass.setBinalData(DashboardActivity.this, SharPrefClass.KEY_FIREBSE_ALLOW, isChecked);
            mNotiSwitchBtn.setChecked(isChecked);
        });*/

        bottomNavigationView.setOnItemSelectedListener(item -> {
            switch (item.getItemId()) {
                case R.id.nav_home:
                    viewPager.setCurrentItem(0);
                    return true;
                case R.id.nav_funds:
                    viewPager.setCurrentItem(2);
                    return true;
                case R.id.nav_my_bids:
                    startActivity(new Intent(DashboardActivity.this, WonHistoryActivity.class)
                            .putExtra(getString(R.string.history), 200));
                    return false; // Don't select
                case R.id.nav_game_rates:
                    startActivity(new Intent(DashboardActivity.this, GameValuesActivity.class)
                            .putExtra(getString(R.string.main_activity), 1));
                    return false; // Don't select
                // case R.id.nav_telegram:
                //     try {
                //         Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("https://t.me/" + SharPrefClass.getRegistrationObject(DashboardActivity.this, SharPrefClass.KEY_TELEGRAM_LINK)));
                //         startActivity(intent);
                //     } catch (Exception e) {
                //         Toast.makeText(DashboardActivity.this, "Telegram not found", Toast.LENGTH_SHORT).show();
                //     }
                //     return false; // Don't select
                case R.id.nav_chart:
                    viewPager.setCurrentItem(3);
                    return true;
            }
            return false;
        });

        viewPager.addOnPageChangeListener(new androidx.viewpager.widget.ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {}

            @Override
            public void onPageSelected(int position) {
                if (position == 0) {
                    bottomNavigationView.getMenu().findItem(R.id.nav_home).setChecked(true);
                } else if (position == 2) {
                    bottomNavigationView.getMenu().findItem(R.id.nav_funds).setChecked(true);
                } else if (position == 3) {
                    bottomNavigationView.getMenu().findItem(R.id.nav_chart).setChecked(true);
                }
            }

            @Override
            public void onPageScrollStateChanged(int state) {}
        });

    }

    private void confiData() {

        if (YourService.isOnline(this)){
            checkUserStatusMethod();
            getGameListMethod(DashboardActivity.this);
            getTurnamentList(DashboardActivity.this);
            getDesawarGame(DashboardActivity.this);
            purseStatementMethod(DashboardActivity.this);
            getUserInfoMethod(DashboardActivity.this, SharPrefClass.getLoginInToken(DashboardActivity.this));
        }
        else Toast.makeText(this, "Check Your Internet Connection", Toast.LENGTH_SHORT).show();

    }

    private void intVariables() {
        mDrawerLayout = findViewById(R.id.drawerLayout);
        mToolbar = findViewById(R.id.toolbar);
        mNaviView = findViewById(R.id.navigationView);
        refreshLayout= findViewById(R.id.swipe_ref_lyt);
        mProgressBar = findViewById(R.id.progressBar);
        mDataConText = findViewById(R.id.dataConText);
        viewPager = findViewById(R.id.viewPager);
        tabLayout = findViewById(R.id.tabs);
        bottomNavigationView = findViewById(R.id.bottom_navigation);
        viewPager.setOffscreenPageLimit(3);
        viewPagerAppliance = new ViewPagerAppliance(getSupportFragmentManager());

        mNaviView.setItemIconTintList(android.content.res.ColorStateList.valueOf(android.graphics.Color.WHITE));
        userName = mNaviView.getHeaderView(0).findViewById(R.id.userDName);
        mMobileNum = mNaviView.getHeaderView(0).findViewById(R.id.mobile_nav_num);
        mNotiSwitchBtn = mNaviView.getHeaderView(0).findViewById(R.id.notiSwitchBtn);

        purse = mNaviView.getMenu().findItem(R.id.purse);
        mBankAc = mNaviView.getMenu().findItem(R.id.bank_ac);
        mpurseMenu = mToolbar.getMenu().findItem(R.id.purse);
        mCoins = mToolbar.getMenu().findItem(R.id.coins);
        howToLearn = mNaviView.getMenu().findItem(R.id.how_to_learn);
        mGameValues = mNaviView.getMenu().findItem(R.id.game_values);
        if (userName != null) {
            userName.setText(SharPrefClass.getRegistrationObject(this, SharPrefClass.KEY_USER_NAME));
        }
        if (mMobileNum != null) {
            mMobileNum.setText(SharPrefClass.getRegistrationObject(this, SharPrefClass.KEY_PHONE_NUMBER));
        }
        if (mNotiSwitchBtn != null) {
            mNotiSwitchBtn.setChecked(SharPrefClass.getBinalObject(this, SharPrefClass.KEY_FIREBSE_ALLOW, true));
        }

        profile = mNaviView.getMenu().findItem(R.id.profile);
        contactUs = mNaviView.getMenu().findItem(R.id.contactUs);
        changePassword = mNaviView.getMenu().findItem(R.id.changePassword);
        logout = mNaviView.getMenu().findItem(R.id.logout);

//        walletIconLayout = mToolbar.findViewById(R.id.wallet_icon_layout);
//        notificationIconLayout = mToolbar.findViewById(R.id.notification_icon_layout);
//        walletCountBadge = mToolbar.findViewById(R.id.wallet_count_badge);
        mNotificationIcon = findViewById(R.id.notification_icon);
        mWalletBalanceText = findViewById(R.id.wallet_balance_text);
        mMenuPill = findViewById(R.id.menu_button);
        mWalletPill = findViewById(R.id.wallet_pill);
        notificationBadge = findViewById(R.id.notification_badge);

        mToolbar.setTitle(getString(R.string.app_name));
        mToolbar.setOnMenuItemClickListener(item -> {
            if (item.getItemId() == R.id.notification) {
                startActivity(new Intent(this, NotificationActivity.class));
            } else if (item.getItemId() == R.id.purse) {
                viewPager.setCurrentItem(2, true);
            }
            return true;
        });

        // Custom Header Click Listeners
        if (mMenuPill != null) {
            mMenuPill.setOnClickListener(v -> mDrawerLayout.openDrawer(GravityCompat.START));
        }
        if (mWalletPill != null) {
            mWalletPill.setOnClickListener(v -> viewPager.setCurrentItem(2, true));
        }

        if (mNotificationIcon != null) {
            mNotificationIcon.setOnClickListener(v -> startActivity(new Intent(DashboardActivity.this, NotificationActivity.class)));
        }

        if (SharPrefClass.getSharedBooleanStatus(this, SharPrefClass.KEY_DEVELOPER_MODE)){
            mToolbar.setTitle(getString(R.string.app_name));
            if (profile != null) profile.setVisible(false);
            if (contactUs != null) contactUs.setVisible(false);
            if (changePassword != null) changePassword.setVisible(false);
            if (logout != null) logout.setTitle("Exit App");
            if (userName != null) userName.setVisibility(View.GONE);
            if (mMobileNum != null) mMobileNum.setVisibility(View.GONE);
        }else {
            if (profile != null) profile.setVisible(true);
            if (contactUs != null) contactUs.setVisible(true);
            if (changePassword != null) changePassword.setVisible(true);
            if (logout != null) logout.setTitle(getString(R.string.signout));
            if (userName != null) userName.setVisibility(View.VISIBLE);
            if (mMobileNum != null) mMobileNum.setVisibility(View.VISIBLE);
        }
    }
    private volatile boolean isActive = false;

    @Override
    protected void onResume() {
        super.onResume();
        if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.TIRAMISU) {
            registerReceiver(myReceiver, mIntentFilter, Context.RECEIVER_NOT_EXPORTED);
        } else {
            registerReceiver(myReceiver, mIntentFilter);
        }
        fetchNotificationCount();
    }
    
    private void fetchNotificationCount() {
        new Thread(() -> {
            try {
                java.net.URL url = new java.net.URL("https://wonder1club.click/get_notifications.php");
                java.net.HttpURLConnection conn = (java.net.HttpURLConnection) url.openConnection();
                conn.setRequestMethod("GET");
                conn.setConnectTimeout(8000);
                conn.setReadTimeout(8000);

                java.io.BufferedReader in = new java.io.BufferedReader(new java.io.InputStreamReader(conn.getInputStream()));
                StringBuilder result = new StringBuilder();
                String line;
                while ((line = in.readLine()) != null) result.append(line);
                in.close();

                org.json.JSONArray jsonArray = new org.json.JSONArray(result.toString());
                int count = jsonArray.length();

                runOnUiThread(() -> {
                    if (notificationBadge != null) {
                        if (count > 0) {
                            notificationBadge.setText(String.valueOf(count));
                            notificationBadge.setVisibility(View.VISIBLE);
                        } else {
                            notificationBadge.setVisibility(View.GONE);
                        }
                    }
                });

            } catch (Exception e) {
                e.printStackTrace();
                runOnUiThread(() -> {
                    if (notificationBadge != null) {
                        notificationBadge.setVisibility(View.GONE);
                    }
                });
            }
        }).start();
    }

    @Override
    protected void onPause() {
        super.onPause();
        try {
            unregisterReceiver(myReceiver);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

private void checkUserStatusMethod() {
        refreshLayout.setRefreshing(true);
        Call<DataProfileStatus> call = ApiClass.getClient().Customer_status(SharPrefClass.getLoginInToken(this), "");
        call.enqueue(new Callback<DataProfileStatus>() {
            @Override
            public void onResponse(@NonNull Call<DataProfileStatus> call, @NonNull Response<DataProfileStatus> response) {
                if (response.isSuccessful()) {
                    DataProfileStatus dataProfileStatus = response.body();
                    if (dataProfileStatus.getCode().equalsIgnoreCase("505")) {
                        SharPrefClass.setCleaninfo(DashboardActivity.this);
                        Toast.makeText(DashboardActivity.this, dataProfileStatus.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(DashboardActivity.this, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataProfileStatus.getStatus().equalsIgnoreCase(getString(R.string.success))) {
                        SharPrefClass.setUserCoins(DashboardActivity.this, dataProfileStatus.getData().getAvailablePoints());
                        SharPrefClass.setTransmitCoins(DashboardActivity.this, dataProfileStatus.getData().getTransferPoint().equalsIgnoreCase("1"));
                        SharPrefClass.setAddAmountUPI(DashboardActivity.this, SharPrefClass.KEY_ADD_COINS_BHIM_ID, dataProfileStatus.getData().getUpiPaymentId());
                        SharPrefClass.setAddAmountUPI(DashboardActivity.this, SharPrefClass.KEY_ADD_COINS_BHIM_NAME, dataProfileStatus.getData().getUpiName());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MAX_ADD_AMOUNT_COINS, dataProfileStatus.getData().getMaximumDeposit());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MIN_ADD_AMOUNT_COINS, dataProfileStatus.getData().getMinimumDeposit());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MAX_EXTRACT_COINS, dataProfileStatus.getData().getMaximumWithdraw());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MIN_EXTRACT_COINS, dataProfileStatus.getData().getMinimumWithdraw());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MAX_OFFER_SUM, dataProfileStatus.getData().getMaximumBidAmount());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MIN_OFFER_SUM, dataProfileStatus.getData().getMinimumBidAmount());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MAX_TRANSMIT_COINS, dataProfileStatus.getData().getMaximumTransfer());
                        SharPrefClass.setMaxMinData(DashboardActivity.this, SharPrefClass.KEY_MIN_TRANSMIT_COINS, dataProfileStatus.getData().getMinimumTransfer());
                        mAvaPoints = Integer.parseInt(dataProfileStatus.getData().getAvailablePoints());
                        setToolBarTitle(mAvaPoints);
                        if (mMinWithdCoins != null) {
                            mMinWithdCoins.setText("Minimum withdrawal points are - " + dataProfileStatus.getData().getMinimumWithdraw());
                        }
                    }

                    // Check if the user is live
                    boolean isLiveUser = dataProfileStatus.getStatus().equalsIgnoreCase("success");
                    SharPrefClass.setLiveUser(DashboardActivity.this, isLiveUser);

                    // If the user is not live, go to QuizActivity, otherwise call updateUserStatus
                    if (!isLiveUser) {
                        hideFullScreenLoader();
                        Intent intent = new Intent(DashboardActivity.this, QuizActivity.class);
                        startActivity(intent);
                        finish();
                    } else {
                        hideFullScreenLoader();
                        updateUserStatus();

                    }
                } else {
                    Toast.makeText(DashboardActivity.this, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                refreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(Call<DataProfileStatus> call, Throwable t) {
                Toast.makeText(DashboardActivity.this, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
                System.out.println("user_status error " + t);
                refreshLayout.setRefreshing(false);
            }
        });
    }
    private void updateUserStatus() {
        if (!SharPrefClass.getLiveUser(this)){
            if (purse != null) purse.setVisible(false);
            if (mCoins != null) mCoins.setVisible(false);
            if (mBankAc != null) mBankAc.setVisible(false);
            if (mpurseMenu != null) mpurseMenu.setVisible(false);
            if (howToLearn != null) howToLearn.setVisible(false);
            if (mGameValues != null) mGameValues.setVisible(false);
            if (tabLayout != null) tabLayout.setVisibility(View.GONE);
        }else{
            if (purse != null) purse.setVisible(true);
            if (mCoins != null) mCoins.setVisible(true);
            if (mBankAc != null) mBankAc.setVisible(true);
            if (mpurseMenu != null) mpurseMenu.setVisible(true);
            if (howToLearn != null) howToLearn.setVisible(true);
            if (mGameValues != null) mGameValues.setVisible(true);
            if (tabLayout != null) tabLayout.setVisibility(View.GONE);
        }
    }

    private void confToolbar() {
        mToolbar.setNavigationOnClickListener(v -> mDrawerLayout.openDrawer(GravityCompat.START));
        mNaviView.setNavigationItemSelectedListener(item -> {
            switch (item.getItemId()){
                case R.id.home:
                    mDrawerLayout.closeDrawers();
                    break;
                case R.id.seeFullProfile:
                    Intent profile = new Intent(DashboardActivity.this, UserInfoActivity.class);
                    startActivity(profile);
                    break;
                case R.id.withdrawPoints:
                    Intent withdrawPoints = new Intent(DashboardActivity.this, TakeOutActivity.class);
                    startActivity(withdrawPoints);
                    break;
                case R.id.walletStatement:
                    viewPager.setCurrentItem(2, true);
                    break;
                case R.id.manageBank:
                    Intent manageBank = new Intent(DashboardActivity.this, BActivity.class);
                    startActivity(manageBank);
                    break;
                case R.id.managePaytm:
                    Intent managePaytm = new Intent(DashboardActivity.this, UPIDActivity.class);
                    managePaytm.putExtra(getString(R.string.upi), 1);
                    startActivity(managePaytm);
                    break;
                case R.id.manageGooglePay:
                    Intent manageGooglePay = new Intent(DashboardActivity.this, UPIDActivity.class);
                    manageGooglePay.putExtra(getString(R.string.upi),3);
                    startActivity(manageGooglePay);
                    break;
                case R.id.managePhonePe:
                    Intent managePhonePay = new Intent(DashboardActivity.this, UPIDActivity.class);
                    managePhonePay.putExtra(getString(R.string.upi), 2);
                    startActivity(managePhonePay);
                    break;
                case R.id.winHistory:
                    Intent winHistory = new Intent(DashboardActivity.this, WonHistoryActivity.class);
                    winHistory.putExtra(getString(R.string.history), 100);
                    startActivity(winHistory);
                    break;
                case R.id.bidHistory:
                    Intent bidHistory = new Intent(DashboardActivity.this, WonHistoryActivity.class);
                    bidHistory.putExtra(getString(R.string.history),200);
                    startActivity(bidHistory);
                    break;
                case R.id.game_values:
                    Intent gameRates = new Intent(DashboardActivity.this, GameValuesActivity.class);
                    gameRates.putExtra(getString(R.string.main_activity), 1);
                    startActivity(gameRates);
                    break;
                case R.id.how_to_learn:
                    Intent howToPlay = new Intent(DashboardActivity.this, GameValuesActivity.class);
                    howToPlay.putExtra(getString(R.string.main_activity), 2);
                    startActivity(howToPlay);
                    break;
                case R.id.contactUs:
                    Intent contactUs = new Intent(DashboardActivity.this, UserHelpActivity.class);
                    startActivity(contactUs);
                    break;
                case R.id.shareWithFriends:
                    String shareMessage = "Download " + getString(R.string.app_name) + " for the most reliable results and fast payments! \ud83c\udfc6\ud83d\udcb0\n" +
                            "Join us now: https://wonder1club.click";
                    Intent sendIntent = new Intent();
                    sendIntent.setAction(Intent.ACTION_SEND);
                    sendIntent.putExtra(Intent.EXTRA_TEXT, shareMessage);
                    sendIntent.setType("text/plain");
                    Intent shareIntent = Intent.createChooser(sendIntent, "Share via");
                    startActivity(shareIntent);
                    break;
                case R.id.changePassword:
                    String[] arrayStrings = new String[]{SharPrefClass.getRegistrationObject(DashboardActivity.this, SharPrefClass.KEY_PHONE_NUMBER), SharPrefClass.getLoginInToken(DashboardActivity.this)};
                    Intent changePassword = new Intent(DashboardActivity.this, NewPassActivity.class);
                    changePassword.putExtra(getString(R.string.changePassword), 1);
                    changePassword.putExtra(getString(R.string.phone_number), arrayStrings);
                    startActivity(changePassword);
                    break;
                case R.id.language:
                    startActivity(new Intent(DashboardActivity.this, LanguageActivity.class));
                    break;
                case R.id.logout:
                    LogOutDialog();
                    mDrawerLayout.closeDrawers();
                    break;
            }
            mDrawerLayout.closeDrawers();
            return true;
        });
    }

    private void LogOutDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle(getString(R.string.exit_application));
        builder.setMessage(getString(R.string.are_you_sure_you_want_to_exit));
        builder.setNegativeButton("YES", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                if (SharPrefClass.getSharedBooleanStatus(DashboardActivity.this, SharPrefClass.KEY_DEVELOPER_MODE)){
                    finishAffinity();
                }else {
                    Intent logOut = new Intent(DashboardActivity.this, SignInActivity.class);
                    startActivity(logOut);
                    SharPrefClass.setSigninSuccess(DashboardActivity.this, false);
                }
            }
        });

        builder.setPositiveButton("NO", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {

            }
        });


        AlertDialog alertDialog = builder.create();
        alertDialog.show();
        alertDialog.getButton(DialogInterface.BUTTON_NEGATIVE).setTextColor(Color.BLACK);
        alertDialog.getButton(DialogInterface.BUTTON_NEGATIVE).setTypeface(Typeface.DEFAULT_BOLD);
        alertDialog.getButton(DialogInterface.BUTTON_POSITIVE).setTextColor(Color.BLACK);
        alertDialog.getButton(DialogInterface.BUTTON_POSITIVE).setTypeface(Typeface.DEFAULT_BOLD);

        alertDialog.getWindow().setBackgroundDrawable(ContextCompat.getDrawable(DashboardActivity.this,R.drawable.rounded_corner_white));
        alertDialog.getWindow().setLayout(900, LinearLayout.LayoutParams.WRAP_CONTENT);
    }
    private void getUserInfoMethod(DashboardActivity activity, String token) {
        mProgressBar.setVisibility(View.VISIBLE);
        Call<DataLogIN> call = ApiClass.getClient().GetUserInfo(token,"");
        call.enqueue(new Callback<DataLogIN>() {
            @Override
            public void onResponse(Call<DataLogIN> call, Response<DataLogIN> response) {
                if (response.isSuccessful()){
                    DataLogIN dataLogIN = response.body();
                    if (dataLogIN.getCode().equalsIgnoreCase("505")){
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataLogIN.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataLogIN.getStatus().equalsIgnoreCase(getString(R.string.success))){
                        SharPrefClass.setRegisterData(activity, SharPrefClass.KEY_USER_NAME, dataLogIN.getData().getUsername());
                        SharPrefClass.setRegisterData(activity, SharPrefClass.KEY_PHONE_NUMBER, dataLogIN.getData().getMobile());
                        SharPrefClass.setPrefrenceStrngData(activity, SharPrefClass.KEY_CLIENT_EMAIL, dataLogIN.getData().getEmail());
                        SharPrefClass.setBankInformation(activity, SharPrefClass.KEY_BANK_USER_NAME, dataLogIN.getData().getAccount_holder_name());
                        SharPrefClass.setBankInformation(activity, SharPrefClass.KEY_B_AC_N, dataLogIN.getData().getBank_account_no());
                        SharPrefClass.setBankInformation(activity, SharPrefClass.KEY_B_IFSC_C, dataLogIN.getData().getIfsc_code());
                        SharPrefClass.setBankInformation(activity, SharPrefClass.KEY_B_N, dataLogIN.getData().getBank_name());
                        SharPrefClass.setBankInformation(activity, SharPrefClass.KEY_BRANCH_ADDRESS, dataLogIN.getData().getBranch_address());
                        SharPrefClass.setPrefrenceStrngData(activity, SharPrefClass.KEY_P_UPI_ID, dataLogIN.getData().getPaytm_mobile_no());
                        SharPrefClass.setPrefrenceStrngData(activity, SharPrefClass.KEY_PP_UPI_ID, dataLogIN.getData().getPhonepe_mobile_no());
                        SharPrefClass.setPrefrenceStrngData(activity, SharPrefClass.KEY_G_PAY_UPI_ID, dataLogIN.getData().getGpay_mobile_no());

                        if (user_name != null) {
                            user_name.setText("Hello,  " + dataLogIN.getData().getUsername());
                        }
                        if (userName != null) {
                            userName.setText(dataLogIN.getData().getUsername());
                        }
                        if (mMobileNum != null) {
                            mMobileNum.setText(dataLogIN.getData().getMobile());
                        }
                    }else
                        Toast.makeText(activity, dataLogIN.getMessage(), Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                mProgressBar.setVisibility(View.GONE);
                DashboardFragment.recall();
                StarlineFragment.recall();
                WalletFragment.recall();
            }

            @Override
            public void onFailure(Call<DataLogIN> call, Throwable t) {
                mProgressBar.setVisibility(View.GONE);
                System.out.println("getUserDetails error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();

            }
        });
    }

    private void setToolBarTitle(int i) {
        if (mpurseMenu != null) {
            mpurseMenu.setTitle(String.valueOf(i));
        }
        if (mWalletBalanceText != null) {
            mWalletBalanceText.setText(String.valueOf(i));
        }
        SpannableString s = new SpannableString(String.valueOf(i));
        s.setSpan(new ForegroundColorSpan(Color.WHITE), 0, s.length(), 0);
        s.setSpan(new RelativeSizeSpan(1.50f),0,s.length(),0);
        s.setSpan(new StyleSpan(Typeface.BOLD),0,s.length(),0);
        if (mCoins != null) {
            mCoins.setTitle(s);
        }
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
    public void onBackPressed() {
        if (mDrawerLayout.isDrawerOpen(mNaviView)){
            mDrawerLayout.closeDrawers();
            return;
        }
        if (viewPager.getCurrentItem()!=0){
            viewPager.setCurrentItem(0, true);
            return;
        }
        finishAffinity();
    }

    private void getGameListMethod(DashboardActivity activity) {
        mProgressBar.setVisibility(View.VISIBLE);
        Call<DataGameList> call = ApiClass.getClient().MainTournamentList(SharPrefClass.getLoginInToken(activity), "");
        call.enqueue(new Callback<DataGameList>() {
            @Override
            public void onResponse(@NonNull Call<DataGameList> call, @NonNull Response<DataGameList> response) {
                if (response.isSuccessful()){
                    DataGameList dataGameList = response.body();
                    assert dataGameList != null;
                    if (dataGameList.getCode().equalsIgnoreCase("505")){
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataGameList.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }

                    if(dataGameList.getStatus().equalsIgnoreCase("success")){
                        DashboardFragment.mDataList = dataGameList.getData();
                        DashboardFragment.confRecyView(activity);
                    }
                    if (tabLayout.getSelectedTabPosition()==0){
                        //  Toast.makeText(activity, dataGameList.getMessage()+"1010101010", Toast.LENGTH_SHORT).show();
                    }

                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                mProgressBar.setVisibility(View.GONE);
            }

            @Override
            public void onFailure(@NonNull Call<DataGameList> call, @NonNull Throwable t) {
                mProgressBar.setVisibility(View.GONE);
                System.out.println("game list Error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void getTurnamentList(DashboardActivity activity) {
        refreshLayout.setRefreshing(true);
        Call<DataStarlineGameList> call = ApiClass.getClient().slTurnament(SharPrefClass.getLoginInToken(activity), "");
        call.enqueue(new Callback<DataStarlineGameList>() {
            @Override
            public void onResponse(@NonNull Call<DataStarlineGameList> call, @NonNull Response<DataStarlineGameList> response) {
                if (response.isSuccessful()) {
                    DataStarlineGameList dataStarlineGameList = response.body();
                    assert dataStarlineGameList != null;
                    if (dataStarlineGameList.getCode().equalsIgnoreCase("505")) {
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataStarlineGameList.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataStarlineGameList.getStatus().equalsIgnoreCase("success")) {
                        DataStarlineGameList.Data data = dataStarlineGameList.getData();
                        StarlineFragment.stringURL = data.getStarlineChart();
                        starlineRatesList = data.getStarlineRates();
                        for (int i = 0; i < starlineRatesList.size(); i++) {
                            String value = starlineRatesList.get(i).getCost_amount() + "-" + starlineRatesList.get(i).getEarning_amount();
                            if (i == 0 && sinDV != null) sinDV.setText(value);
                            if (i == 1 && sinPV != null) sinPV.setText(value);
                            if (i == 2 && dobPV != null) dobPV.setText(value);
                            if (i == 3 && triPV != null) triPV.setText(value);
                        }

                        StarlineFragment.starlineGameList = data.getStarlineGame();
                        StarlineFragment.confRecycler(activity);
                    }
                    if (tabLayout != null && tabLayout.getSelectedTabPosition()==1){}
                 //   Toast.makeText(activity, dataStarlineGameList.getMessage(), Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                refreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(@NonNull Call<DataStarlineGameList> call, @NonNull Throwable t) {
                refreshLayout.setRefreshing(false);
                System.out.println("game list Error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
            }
        });

    }
    private void getDesawarGame(DashboardActivity activity) {
        refreshLayout.setRefreshing(true);
        Call<DataStarlineGameList> call = ApiClass.getClient().slTurnament(SharPrefClass.getLoginInToken(activity), "");
        call.enqueue(new Callback<DataStarlineGameList>() {
            @Override
            public void onResponse(@NonNull Call<DataStarlineGameList> call, @NonNull Response<DataStarlineGameList> response) {
                if (response.isSuccessful()) {
                    DataStarlineGameList dataStarlineGameList = response.body();
                    assert dataStarlineGameList != null;
                    if (dataStarlineGameList.getCode().equalsIgnoreCase("505")) {
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataStarlineGameList.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataStarlineGameList.getStatus().equalsIgnoreCase("success")) {
                        DataStarlineGameList.Data data = dataStarlineGameList.getData();
                        StarlineFragment.stringURL = data.getStarlineChart();
                        starlineRatesList = data.getStarlineRates();
                        for (int i = 0; i < starlineRatesList.size(); i++) {
                            String value = starlineRatesList.get(i).getCost_amount() + "-" + starlineRatesList.get(i).getEarning_amount();
                            if (i == 0 && sinDV != null) sinDV.setText(value);
                            if (i == 1 && sinPV != null) sinPV.setText(value);
                            if (i == 2 && dobPV != null) dobPV.setText(value);
                            if (i == 3 && triPV != null) triPV.setText(value);
                        }

                        StarlineFragment.starlineGameList = data.getStarlineGame();
                        StarlineFragment.confRecycler(activity);
                    }
                    if (tabLayout != null && tabLayout.getSelectedTabPosition()==1){}
                    //   Toast.makeText(activity, dataStarlineGameList.getMessage(), Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                refreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(@NonNull Call<DataStarlineGameList> call, @NonNull Throwable t) {
                refreshLayout.setRefreshing(false);
                System.out.println("game list Error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
            }
        });

    }

    private void purseStatementMethod(DashboardActivity activity) {
        refreshLayout.setRefreshing(true);
        Call<DataWalletHistory> call = ApiClass.getClient().purseStatement(SharPrefClass.getLoginInToken(activity),"");
        call.enqueue(new Callback<DataWalletHistory>() {
            @Override
            public void onResponse(Call<DataWalletHistory> call, Response<DataWalletHistory> response) {
                if (response.isSuccessful()){
                    DataWalletHistory dataWalletHistory = response.body();
                    if (dataWalletHistory.getCode().equalsIgnoreCase("505")){
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataWalletHistory.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataWalletHistory.getStatus().equalsIgnoreCase(getString(R.string.success))){
                        SharPrefClass.setUserCoins(activity, dataWalletHistory.getData().getAvailablePoints());
                        if (WalletFragment.coins != null) {
                            WalletFragment.coins.setText(dataWalletHistory.getData().getAvailablePoints());
                        }
                        if (mWithdOT != null) {
                            mWithdOT.setText("Withdraw Open time = "+ dataWalletHistory.getData().getWithdrawOpenTime());
                        }
                        if (mWithdCT != null) {
                            mWithdCT.setText("Withdraw Close time = "+ dataWalletHistory.getData().getWithdrawCloseTime());
                        }
                        SharPrefClass.setMaxMinData(activity, SharPrefClass.KEY_WITHDRAW_OPEN_TIME, dataWalletHistory.getData().getWithdrawOpenTime());
                        SharPrefClass.setMaxMinData(activity, SharPrefClass.KEY_WITHDRAW_CLOSE_TIME, dataWalletHistory.getData().getWithdrawCloseTime());
                        WalletFragment.modelWalletArrayList = dataWalletHistory.getData().getStatement();
                       WalletFragment.confRecycler(DashboardActivity.this);
                    }

                    if (tabLayout != null && tabLayout.getSelectedTabPosition()==2){
                        //   Toast.makeText(activity, dataWalletHistory.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                refreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(Call<DataWalletHistory> call, Throwable t) {
                refreshLayout.setRefreshing(false);
                System.out.println("walletStatement error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void getAppInfoMethod() {
        Call<DataApp> call = ApiClass.getClient().getAppInfo("");
        call.enqueue(new Callback<DataApp>() {
            @Override
            public void onResponse(@NonNull Call<DataApp> call, @NonNull Response<DataApp> response) {
                if (response.isSuccessful()) {
                    DataApp dataApp = response.body();
                    if (dataApp.getCode().equalsIgnoreCase("505")) {
                        SharPrefClass.setCleaninfo(DashboardActivity.this);
                        Toast.makeText(DashboardActivity.this, dataApp.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(DashboardActivity.this, SignInActivity.class);
                        startActivity(intent);
                        finish();
                        return;
                    }
                    if (dataApp.getStatus().equalsIgnoreCase(getString(R.string.success))) {
                        SharPrefClass.setPrefrenceStrngData(DashboardActivity.this, SharPrefClass.KEY_MAR_TXT, dataApp.getData().getBanner_marquee());
                        SharPrefClass.setContactUsInfo(DashboardActivity.this, SharPrefClass.KEY_PHONE_NUMBER1, "+91" + dataApp.getData().getContact_details().getMobile_no_1());
                        SharPrefClass.setContactUsInfo(DashboardActivity.this, SharPrefClass.KEY_PHONE_NUMBER2,   dataApp.getData().getContact_details().getTelegram_channel_link());
                        SharPrefClass.setContactUsInfo(DashboardActivity.this, SharPrefClass.KEY_WHATSAP_NUMBER, "+91" + dataApp.getData().getContact_details().getWhatsapp_no());
                        SharPrefClass.setContactUsInfo(DashboardActivity.this, SharPrefClass.KEY_REACH_US_EMAIL, dataApp.getData().getContact_details().getEmail_1());
                        SharPrefClass.setPosterImages(DashboardActivity.this, SharPrefClass.KEY_POSTER_IMAGES1, dataApp.getData().getBanner_image().getBanner_img_1());
                        SharPrefClass.setPosterImages(DashboardActivity.this, SharPrefClass.KEY_POSTER_IMAGES2, dataApp.getData().getBanner_image().getBanner_img_2());
                        SharPrefClass.setPosterImages(DashboardActivity.this, SharPrefClass.KEY_POSTER_IMAGES3, dataApp.getData().getBanner_image().getBanner_img_3());

                        DashboardFragment.recall();
                    }
                }
            }
            @Override
            public void onFailure(Call<DataApp> call, Throwable t) {
                System.out.println("getAppDetails error " + t);
            }
        });
    }

}