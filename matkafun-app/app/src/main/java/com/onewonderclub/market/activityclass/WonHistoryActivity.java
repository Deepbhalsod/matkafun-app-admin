package com.onewonderclub.market.activityclass;

import static com.onewonderclub.market.shareprefclass.Utility.BroadCastStringForAction;
import static com.onewonderclub.market.shareprefclass.Utility.myReceiver;

import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textview.MaterialTextView;
import com.onewonderclub.market.adapterclass.DisaWonHistoryAdapter;
import com.onewonderclub.market.adapterclass.SLWonHistoryAdapter;
import com.onewonderclub.market.adapterclass.WonHistoryAdapter;
import com.onewonderclub.market.apiclass.ApiClass;
import com.onewonderclub.market.responseclass.DataDisawarWin;
import com.onewonderclub.market.responseclass.DataStarlineWin;
import com.onewonderclub.market.responseclass.DataWin;
import com.onewonderclub.market.shareprefclass.SharPrefClass;
import com.onewonderclub.market.shareprefclass.Utility;
import com.onewonderclub.market.shareprefclass.YourService;
import com.kalyankuber.alpha.R;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Locale;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class WonHistoryActivity extends AppCompatActivity {

    private MaterialToolbar toolbar;
    private MaterialTextView from_date, to_date, tvNoData;
    private Date f_date, t_date;
    private final SimpleDateFormat userSF = new SimpleDateFormat("dd-MM-yyyy", Locale.getDefault());
    private final SimpleDateFormat serverSF = new SimpleDateFormat("yyyy-MM-dd",Locale.getDefault());
    private final Calendar fromCalender = Calendar.getInstance();
    private final Calendar toCalendar = Calendar.getInstance();
    private final Calendar todayCalwndar = Calendar.getInstance();
    private ShapeableImageView emptyImage;

    private int his =0;
    private RecyclerView recyclerView;
    private WonHistoryAdapter wonHistoryAdapter;
    private SLWonHistoryAdapter SLWonHistoryAdapter;
    private DisaWonHistoryAdapter disaWonHistoryAdapter;
    private List<DataWin.Data> dataArrayList = new ArrayList<>();
    private List<DataStarlineWin.Data> slWonModelList = new ArrayList<>();
    private List<DataDisawarWin.Data> disaWonModelList = new ArrayList<>();

    private List<DataWin.Data> fullDataArrayList = new ArrayList<>();
    private List<DataStarlineWin.Data> fullSlWonModelList = new ArrayList<>();
    private List<DataDisawarWin.Data> fullDisaWonModelList = new ArrayList<>();

    private String selectedMarket = "All Markets";
    private int selectedStatusPos = 0; // 0: All, 1: Pending, 2: Win, 3: Loss, 4: Canceled

    private SwipeRefreshLayout swipeRefreshLayout;
    private Call<DataWin> call;
    private Call<DataStarlineWin> sLCall;
    private Call<DataDisawarWin> disaCall;
    private IntentFilter mIntentFilter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_won_history);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(getResources().getColor(R.color.matka_blue));

        intVariables();
        loadData();
        toolbarMethod();


    }

    private void loadData() {
        mIntentFilter = new IntentFilter();
        mIntentFilter.addAction(BroadCastStringForAction);
        Intent serviceIntent = new Intent(this, YourService.class);
        startService(serviceIntent);

        f_date = Calendar.getInstance().getTime();
        t_date = Calendar.getInstance().getTime();
        his = getIntent().getIntExtra(getString(R.string.history), 0);
        if (his ==100 || his ==200){
            historyMethod(WonHistoryActivity.this, f_date, t_date);
        }
        if (his ==300 || his ==400){
            winHistoryHistoryMethod(WonHistoryActivity.this, f_date, t_date);
        }
        if (his==500||his==600){
            desawarHistoryMethod(WonHistoryActivity.this, f_date, t_date);
        }
    }


    private void intVariables() {
        toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        recyclerView = findViewById(R.id.recyclerView);
        emptyImage = findViewById(R.id.emptyImage);
        tvNoData = findViewById(R.id.tv_no_data);
        swipeRefreshLayout = findViewById(R.id.swipe_ref_lyt);

        MaterialTextView dataConText = findViewById(R.id.dataConText);
        Utility utility = new Utility(dataConText);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_won_history, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == R.id.action_filter) {
            showFilterDialog();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    private void showFilterDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        View dialogView = getLayoutInflater().inflate(R.layout.dialog_bid_filter, null);
        builder.setView(dialogView);

        TextView tvFromDate = dialogView.findViewById(R.id.filterFromDate);
        TextView tvToDate = dialogView.findViewById(R.id.filterToDate);
        Spinner spinnerMarket = dialogView.findViewById(R.id.spinnerMarket);
        Spinner spinnerStatus = dialogView.findViewById(R.id.spinnerStatus);
        Button btnReset = dialogView.findViewById(R.id.btnReset);
        Button btnApply = dialogView.findViewById(R.id.btnApply);
        Button btnClose = dialogView.findViewById(R.id.btnClose);

        tvFromDate.setText(userSF.format(f_date));
        tvToDate.setText(userSF.format(t_date));

        // Market List Setup
        List<String> markets = new ArrayList<>();
        markets.add("All Markets");
        if (his == 100 || his == 200) {
            for (DataWin.Data item : fullDataArrayList) {
                if (!markets.contains(item.getGameName())) markets.add(item.getGameName());
            }
        } else if (his == 300 || his == 400) {
            for (DataStarlineWin.Data item : fullSlWonModelList) {
                if (!markets.contains(item.getGameName())) markets.add(item.getGameName());
            }
        } else if (his == 500 || his == 600) {
            for (DataDisawarWin.Data item : fullDisaWonModelList) {
                if (!markets.contains(item.getGameName())) markets.add(item.getGameName());
            }
        }
        ArrayAdapter<String> marketAdapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, markets);
        marketAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerMarket.setAdapter(marketAdapter);

        // Pre-select if already filtered
        int marketPos = markets.indexOf(selectedMarket);
        if (marketPos != -1) spinnerMarket.setSelection(marketPos);
        spinnerStatus.setSelection(selectedStatusPos);

        final AlertDialog dialog = builder.create();
        dialog.show();

        tvFromDate.setOnClickListener(v -> {
            DatePickerDialog datePicker = new DatePickerDialog(this, android.R.style.Theme_Holo_Light_Panel, (view, year, month, dayOfMonth) -> {
                fromCalender.set(year, month, dayOfMonth);
                f_date = fromCalender.getTime();
                tvFromDate.setText(userSF.format(f_date));
            }, fromCalender.get(Calendar.YEAR), fromCalender.get(Calendar.MONTH), fromCalender.get(Calendar.DAY_OF_MONTH));
            datePicker.getDatePicker().setMaxDate(System.currentTimeMillis());
            datePicker.show();
        });

        tvToDate.setOnClickListener(v -> {
            DatePickerDialog datePicker = new DatePickerDialog(this, android.R.style.Theme_Holo_Light_Panel, (view, year, month, dayOfMonth) -> {
                toCalendar.set(year, month, dayOfMonth);
                t_date = toCalendar.getTime();
                tvToDate.setText(userSF.format(t_date));
            }, toCalendar.get(Calendar.YEAR), toCalendar.get(Calendar.MONTH), toCalendar.get(Calendar.DAY_OF_MONTH));
            datePicker.getDatePicker().setMaxDate(System.currentTimeMillis());
            datePicker.show();
        });

        btnApply.setOnClickListener(v -> {
            selectedMarket = spinnerMarket.getSelectedItem().toString();
            selectedStatusPos = spinnerStatus.getSelectedItemPosition();
            applyFilters();
            dialog.dismiss();
        });

        btnReset.setOnClickListener(v -> {
            f_date = Calendar.getInstance().getTime();
            t_date = Calendar.getInstance().getTime();
            selectedMarket = "All Markets";
            selectedStatusPos = 0;
            refreshDataFromServer();
            dialog.dismiss();
        });

        btnClose.setOnClickListener(v -> dialog.dismiss());
    }

    private void applyFilters() {
        // First check if date has changed, if so, we need to fetch from server first then filter locally.
        // For simplicity, let's just filter locally on the current data list.
        // Usually date filter needs an API call.
        refreshDataFromServer();
    }

    private void refreshDataFromServer() {
        if (his == 100 || his == 200) {
            historyMethod(WonHistoryActivity.this, f_date, t_date);
        } else if (his == 300 || his == 400) {
            winHistoryHistoryMethod(WonHistoryActivity.this, f_date, t_date);
        } else if (his == 500 || his == 600) {
            desawarHistoryMethod(WonHistoryActivity.this, f_date, t_date);
        }
    }

    private void filterDataLocally() {
        if (his == 100 || his == 200) {
            dataArrayList = new ArrayList<>();
            for (DataWin.Data item : fullDataArrayList) {
                if (matchesFilter(item.getGameName(), item.getWinPoints(), item.getWonAt())) {
                    dataArrayList.add(item);
                }
            }
            wonHistoryAdapter = new WonHistoryAdapter(this, dataArrayList);
            recyclerView.setAdapter(wonHistoryAdapter);
            int visibility = dataArrayList.isEmpty() ? View.VISIBLE : View.GONE;
            emptyImage.setVisibility(visibility);
            tvNoData.setVisibility(visibility);
        } else if (his == 300 || his == 400) {
            slWonModelList = new ArrayList<>();
            for (DataStarlineWin.Data item : fullSlWonModelList) {
                if (matchesFilter(item.getGameName(), item.getWinPoints(), item.getWonAt())) {
                    slWonModelList.add(item);
                }
            }
            SLWonHistoryAdapter = new SLWonHistoryAdapter(this, slWonModelList);
            recyclerView.setAdapter(SLWonHistoryAdapter);
            int visibility = slWonModelList.isEmpty() ? View.VISIBLE : View.GONE;
            emptyImage.setVisibility(visibility);
            tvNoData.setVisibility(visibility);
        } else if (his == 500 || his == 600) {
            disaWonModelList = new ArrayList<>();
            for (DataDisawarWin.Data item : fullDisaWonModelList) {
                if (matchesFilter(item.getGameName(), item.getWinPoints(), item.getWonAt())) {
                    disaWonModelList.add(item);
                }
            }
            disaWonHistoryAdapter = new DisaWonHistoryAdapter(this, disaWonModelList);
            recyclerView.setAdapter(disaWonHistoryAdapter);
            int visibility = disaWonModelList.isEmpty() ? View.VISIBLE : View.GONE;
            emptyImage.setVisibility(visibility);
            tvNoData.setVisibility(visibility);
        }
    }

    private boolean matchesFilter(String gameName, String winPoints, String wonAt) {
        boolean marketMatch = selectedMarket.equals("All Markets") || gameName.equals(selectedMarket);
        if (!marketMatch) return false;

        if (selectedStatusPos == 0) return true; // All Status

        boolean isWin = !TextUtils.isEmpty(winPoints) && !winPoints.equals("0") && !winPoints.equals("null");
        boolean isResultDeclared = !TextUtils.isEmpty(wonAt) && !wonAt.equalsIgnoreCase("null");
        
        switch (selectedStatusPos) {
            case 1: // Pending
                return !isResultDeclared;
            case 2: // Win
                return isWin;
            case 3: // Loss
                return isResultDeclared && !isWin;
            case 4: // Canceled (Assuming 0 points and declared but maybe special logic? using 0 points and declared for now)
                return false; // Not sure how to detect cancel yet
        }
        return true;
    }
    DatePickerDialog.OnDateSetListener toDatePicker = new DatePickerDialog.OnDateSetListener() {
        @Override
        public void onDateSet(DatePicker view, int year, int monthOfYear,
                              int dayOfMonth) {
            toCalendar.set(Calendar.YEAR, year);
            toCalendar.set(Calendar.MONTH, monthOfYear);
            toCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
            if(toCalendar.getTimeInMillis()< fromCalender.getTimeInMillis()){
                Toast.makeText(WonHistoryActivity.this, "To Date can't be smaller then From Date", Toast.LENGTH_SHORT).show();
                return;
            }
            t_date = toCalendar.getTime();
            refreshDataFromServer();
        }
    };

    DatePickerDialog.OnDateSetListener fromDatePicker = new DatePickerDialog.OnDateSetListener() {
        @Override
        public void onDateSet(DatePicker view, int year, int monthOfYear,
                              int dayOfMonth) {
            fromCalender.set(Calendar.YEAR, year);
            fromCalender.set(Calendar.MONTH, monthOfYear);
            fromCalender.set(Calendar.DAY_OF_MONTH, dayOfMonth);
            f_date = fromCalender.getTime();
            refreshDataFromServer();
        }
    };

    private void toolbarMethod() {
        if (getSupportActionBar() != null) {
            if (his == 100) {
                getSupportActionBar().setTitle(getString(R.string.win_his));
            } else {
                getSupportActionBar().setTitle(getString(R.string.bid_his));
            }
        }

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });

        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                if (his ==100 || his ==200){
                    historyMethod(WonHistoryActivity.this, f_date, t_date);
                }
                if (his ==300 || his ==400){
                    winHistoryHistoryMethod(WonHistoryActivity.this, f_date, t_date);
                }
            }
        });
    }
    public void fromDate(View view) {
        DatePickerDialog datePickerDialog=  new DatePickerDialog(this,android.R.style.Theme_Holo_Light_Panel, fromDatePicker, fromCalender
                .get(Calendar.YEAR), fromCalender.get(Calendar.MONTH), fromCalender.get(Calendar.DAY_OF_MONTH));
        datePickerDialog.show();
        long maxDate = todayCalwndar.getTime().getTime() ;
        datePickerDialog.getDatePicker().setMaxDate(maxDate);
        datePickerDialog.setCanceledOnTouchOutside(true);
        datePickerDialog.getDatePicker().setBackgroundColor(getResources().getColor(R.color.white));
        datePickerDialog.show();
    }

    public void toDate(View view) {
        DatePickerDialog datePickerDialog=  new DatePickerDialog(this,android.R.style.Theme_Holo_Light_Panel, toDatePicker, toCalendar
                .get(Calendar.YEAR), toCalendar.get(Calendar.MONTH), toCalendar.get(Calendar.DAY_OF_MONTH));
        datePickerDialog.show();


        long maxDate = todayCalwndar.getTime().getTime() ;
        datePickerDialog.getDatePicker().setMaxDate(maxDate);
        datePickerDialog.setCanceledOnTouchOutside(true);
        datePickerDialog.getDatePicker().setBackgroundColor(getResources().getColor(R.color.white));
        datePickerDialog.show();
    }



    public void submitWinHistory(View view) {

        if (his ==100 || his ==200){
            historyMethod(WonHistoryActivity.this, f_date, t_date);
        }
        if (his ==300 || his ==400){
            winHistoryHistoryMethod(WonHistoryActivity.this, f_date, t_date);
        }
    }

    private void winHistoryHistoryMethod(WonHistoryActivity activity, Date fDate, Date tDate) {
        String fromDate = serverSF.format(fDate) + " 00:00:00";
        String toDate = serverSF.format(tDate) + " 23:59:59";

        swipeRefreshLayout.setRefreshing(true);
        switch (his){
            case 300:
                sLCall = ApiClass.getClient().HistorySLBids(SharPrefClass.getLoginInToken(activity),fromDate, toDate);
                break;
            case 400:
                sLCall = ApiClass.getClient().starLineBidHistory(SharPrefClass.getLoginInToken(activity),fromDate, toDate);
                break;
        }

        sLCall.enqueue(new Callback<DataStarlineWin>() {
            @Override
            public void onResponse(@NonNull Call<DataStarlineWin> call, @NonNull Response<DataStarlineWin> response) {
                if (response.isSuccessful()){
                    DataStarlineWin dataStarlineWin = response.body();
                    if (dataStarlineWin.getCode().equalsIgnoreCase("505")){
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataStarlineWin.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataStarlineWin.getStatus().equalsIgnoreCase(getString(R.string.success))){
                        LinearLayoutManager layoutManager = new LinearLayoutManager(activity);

                        fullSlWonModelList = dataStarlineWin.getData();
                        recyclerView.setLayoutManager(layoutManager);
                        filterDataLocally();
                    }else {
                        fullSlWonModelList = new ArrayList<>();
                        filterDataLocally();
                    }
                    Toast.makeText(activity, dataStarlineWin.getMessage(), Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(Call<DataStarlineWin> call, Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                System.out.println("bidHistory error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();

            }
        });
    }

    private void historyMethod(WonHistoryActivity activity, Date fDate, Date tDate) {
        String fromDate = serverSF.format(fDate) + " 00:00:00";
        String toDate = serverSF.format(tDate) + " 23:59:59";
        swipeRefreshLayout.setRefreshing(true);
        switch (his){
            case 100:
                call = ApiClass.getClient().HistoryOfWins(SharPrefClass.getLoginInToken(activity),fromDate, toDate);
                break;
            case 200:
                call = ApiClass.getClient().HistoryOfBids(SharPrefClass.getLoginInToken(activity),fromDate, toDate);
                break;
        }

        call.enqueue(new Callback<DataWin>() {
            @Override
            public void onResponse(@NonNull Call<DataWin> call, @NonNull Response<DataWin> response) {
                if (response.isSuccessful()){
                    DataWin dataWin = response.body();
                    if (dataWin.getCode().equalsIgnoreCase("505")){
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataWin.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    System.out.println("winModel.getStatus() "+ dataWin.getStatus());
                    if (dataWin.getStatus().equalsIgnoreCase(getString(R.string.success))){
                        LinearLayoutManager layoutManager = new LinearLayoutManager(activity);

                        fullDataArrayList = dataWin.getData();
                        recyclerView.setLayoutManager(layoutManager);
                        filterDataLocally();
                    }else {
                        fullDataArrayList = new ArrayList<>();
                        filterDataLocally();
                    }
                    Toast.makeText(activity, dataWin.getMessage(), Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(Call<DataWin> call, Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                System.out.println("bidHistory error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();

            }
        });

    }
    private void desawarHistoryMethod(WonHistoryActivity activity, Date fDate, Date tDate) {
        String fromDate = serverSF.format(fDate) + " 00:00:00";
        String toDate = serverSF.format(tDate) + " 23:59:59";
        swipeRefreshLayout.setRefreshing(true);
        switch (his){
            case 500:
                disaCall = ApiClass.getClient().deasawarBidHistory(SharPrefClass.getLoginInToken(activity),fromDate, toDate);
                break;
            case 600:
                disaCall = ApiClass.getClient().desawarWinHistory(SharPrefClass.getLoginInToken(activity),fromDate, toDate);
                break;
        }

        disaCall.enqueue(new Callback<DataDisawarWin>() {
            @Override
            public void onResponse(@NonNull Call<DataDisawarWin> call, @NonNull Response<DataDisawarWin> response) {
                if (response.isSuccessful()){
                    DataDisawarWin dataDisawarWin = response.body();
                    if (dataDisawarWin.getCode().equalsIgnoreCase("505")){
                        SharPrefClass.setCleaninfo(activity);
                        Toast.makeText(activity, dataDisawarWin.getMessage(), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(activity, SignInActivity.class);
                        startActivity(intent);
                        finish();
                    }
                    if (dataDisawarWin.getStatus().equalsIgnoreCase(getString(R.string.success))){
                        LinearLayoutManager layoutManager = new LinearLayoutManager(activity);
                        fullDisaWonModelList = dataDisawarWin.getData();

                        recyclerView.setLayoutManager(layoutManager);
                        filterDataLocally();
                    }else {
                        fullDisaWonModelList = new ArrayList<>();
                        recyclerView.setVisibility(View.GONE);
                        emptyImage.setVisibility(View.VISIBLE);
                    }
                    Toast.makeText(activity, dataDisawarWin.getMessage(), Toast.LENGTH_SHORT).show();
                }else {
                    Toast.makeText(activity, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(Call<DataDisawarWin> call, Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                System.out.println("bidHistory error "+t);
                Toast.makeText(activity, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();

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
    protected void onResume() {
        super.onResume();
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
}