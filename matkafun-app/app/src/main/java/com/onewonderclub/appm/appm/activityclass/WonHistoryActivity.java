package com.onewonderclub.appm.appm.activityclass;

import static com.onewonderclub.appm.appm.shareprefclass.Utility.BroadCastStringForAction;
import static com.onewonderclub.appm.appm.shareprefclass.Utility.myReceiver;

import android.app.DatePickerDialog;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textview.MaterialTextView;
import com.kalyankuber.alpha.R;
import com.onewonderclub.appm.appm.adapterclass.DisaWonHistoryAdapter;
import com.onewonderclub.appm.appm.adapterclass.SLWonHistoryAdapter;
import com.onewonderclub.appm.appm.adapterclass.WonHistoryAdapter;
import com.onewonderclub.appm.appm.apiclass.ApiClass;
import com.onewonderclub.appm.appm.responseclass.DataDisawarWin;
import com.onewonderclub.appm.appm.responseclass.DataStarlineWin;
import com.onewonderclub.appm.appm.responseclass.DataWin;
import com.onewonderclub.appm.appm.shareprefclass.SharPrefClass;
import com.onewonderclub.appm.appm.shareprefclass.Utility;
import com.onewonderclub.appm.appm.shareprefclass.YourService;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashSet;
import java.util.List;
import java.util.Locale;
import java.util.Set;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class WonHistoryActivity extends AppCompatActivity {

    private MaterialToolbar toolbar;
    private MaterialTextView tvNoData;
    private final SimpleDateFormat userSF = new SimpleDateFormat("dd-MM-yyyy", Locale.getDefault());
    private final SimpleDateFormat serverSF = new SimpleDateFormat("yyyy-MM-dd", Locale.getDefault());
    private ShapeableImageView emptyImage;

    private int his = 0;
    private RecyclerView recyclerView;
    private WonHistoryAdapter wonHistoryAdapter;
    private SLWonHistoryAdapter SLWonHistoryAdapter;
    private DisaWonHistoryAdapter disaWonHistoryAdapter;
    
    // Original API data lists
    private List<DataWin.Data> dataArrayList = new ArrayList<>();
    private List<DataStarlineWin.Data> slWonModelList = new ArrayList<>();
    private List<DataDisawarWin.Data> disaWonModelList = new ArrayList<>();

    // Full backup lists for local filtering
    private List<DataWin.Data> fullDataArrayList = new ArrayList<>();
    private List<DataStarlineWin.Data> fullSlWonModelList = new ArrayList<>();
    private List<DataDisawarWin.Data> fullDisaWonModelList = new ArrayList<>();

    private SwipeRefreshLayout swipeRefreshLayout;
    private Call<DataWin> call;
    private Call<DataStarlineWin> sLCall;
    private Call<DataDisawarWin> disaCall;
    private IntentFilter mIntentFilter;

    // Filter state
    private String filterFromDate = "";
    private String filterToDate = "";
    private String filterMarket = "All Markets";
    private String filterStatus = "All";

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

        his = getIntent().getIntExtra(getString(R.string.history), 0);
        
        Date today = Calendar.getInstance().getTime();
        filterFromDate = serverSF.format(today);
        filterToDate = serverSF.format(today);

        refreshDataFromServer();
    }

    private void intVariables() {
        toolbar = findViewById(R.id.toolbar);
        recyclerView = findViewById(R.id.recyclerView);
        emptyImage = findViewById(R.id.emptyImage);
        tvNoData = findViewById(R.id.tv_no_data);
        swipeRefreshLayout = findViewById(R.id.swipe_ref_lyt);

        MaterialTextView dataConText = findViewById(R.id.dataConText);
        new Utility(dataConText);
        
        setSupportActionBar(toolbar);
    }

    private void toolbarMethod() {
        if (getSupportActionBar() != null) {
            if (his == 100) {
                getSupportActionBar().setTitle(getString(R.string.win_his));
            } else {
                getSupportActionBar().setTitle(getString(R.string.bid_his));
            }
        }

        toolbar.setNavigationOnClickListener(v -> onBackPressed());

        swipeRefreshLayout.setOnRefreshListener(this::refreshDataFromServer);
    }

    private void refreshDataFromServer() {
        if (his == 100 || his == 200) {
            fetchHistory(filterFromDate, filterToDate);
        } else if (his == 300 || his == 400) {
            fetchSLHistory(filterFromDate, filterToDate);
        } else if (his == 500 || his == 600) {
            fetchDesawarHistory(filterFromDate, filterToDate);
        }
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
        View view = getLayoutInflater().inflate(R.layout.dialog_bid_filter, null);
        builder.setView(view);

        TextView tvFrom = view.findViewById(R.id.filterFromDate);
        TextView tvTo = view.findViewById(R.id.filterToDate);
        Spinner spinnerMarket = view.findViewById(R.id.spinnerMarket);
        Spinner spinnerStatus = view.findViewById(R.id.spinnerStatus);
        Button btnApply = view.findViewById(R.id.btnApply);
        Button btnReset = view.findViewById(R.id.btnReset);
        Button btnClose = view.findViewById(R.id.btnClose);

        // Pre-fill
        tvFrom.setText(filterFromDate);
        tvTo.setText(filterToDate);

        // Date pickers
        tvFrom.setOnClickListener(v -> showDatePicker(tvFrom, true));
        tvTo.setOnClickListener(v -> showDatePicker(tvTo, false));

        // Setup Market Spinner
        List<String> markets = new ArrayList<>();
        markets.add("All Markets");
        Set<String> uniqueMarkets = new HashSet<>();
        if (his == 100 || his == 200) {
            for (DataWin.Data d : fullDataArrayList) uniqueMarkets.add(d.getGameName());
        } else if (his == 300 || his == 400) {
            for (DataStarlineWin.Data d : fullSlWonModelList) uniqueMarkets.add(d.getGameName());
        } else if (his == 500 || his == 600) {
            for (DataDisawarWin.Data d : fullDisaWonModelList) uniqueMarkets.add(d.getGameName());
        }
        markets.addAll(uniqueMarkets);
        ArrayAdapter<String> marketAdapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, markets);
        marketAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerMarket.setAdapter(marketAdapter);
        spinnerMarket.setSelection(markets.contains(filterMarket) ? markets.indexOf(filterMarket) : 0);

        // Setup Status Spinner
        ArrayAdapter<CharSequence> statusAdapter = ArrayAdapter.createFromResource(this, R.array.bid_status_array, android.R.layout.simple_spinner_item);
        statusAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerStatus.setAdapter(statusAdapter);
        String[] statusArray = getResources().getStringArray(R.array.bid_status_array);
        for (int i=0; i<statusArray.length;i++) if (statusArray[i].equals(filterStatus)) spinnerStatus.setSelection(i);

        AlertDialog dialog = builder.create();
        
        btnClose.setOnClickListener(v -> dialog.dismiss());
        
        btnReset.setOnClickListener(v -> {
            filterFromDate = serverSF.format(Calendar.getInstance().getTime());
            filterToDate = serverSF.format(Calendar.getInstance().getTime());
            filterMarket = "All Markets";
            filterStatus = "All";
            dialog.dismiss();
            refreshDataFromServer();
        });

        btnApply.setOnClickListener(v -> {
            boolean dateChanged = !filterFromDate.equals(tvFrom.getText().toString()) || !filterToDate.equals(tvTo.getText().toString());
            filterFromDate = tvFrom.getText().toString();
            filterToDate = tvTo.getText().toString();
            filterMarket = spinnerMarket.getSelectedItem().toString();
            filterStatus = spinnerStatus.getSelectedItem().toString();

            dialog.dismiss();
            if (dateChanged) {
                refreshDataFromServer();
            } else {
                filterDataLocally();
            }
        });

        dialog.show();
    }

    private void showDatePicker(TextView tv, boolean isFrom) {
        Calendar cal = Calendar.getInstance();
        try {
            Date d = serverSF.parse(tv.getText().toString());
            if (d != null) cal.setTime(d);
        } catch (Exception ignored) {}

        new DatePickerDialog(this, (view, year, month, dayOfMonth) -> {
            cal.set(Calendar.YEAR, year);
            cal.set(Calendar.MONTH, month);
            cal.set(Calendar.DAY_OF_MONTH, dayOfMonth);
            tv.setText(serverSF.format(cal.getTime()));
        }, cal.get(Calendar.YEAR), cal.get(Calendar.MONTH), cal.get(Calendar.DAY_OF_MONTH)).show();
    }

    private void filterDataLocally() {
        if (his == 100 || his == 200) {
            dataArrayList.clear();
            for (DataWin.Data d : fullDataArrayList) {
                if (matchesFilter(d.getGameName(), d.getWinPoints(), d.getBidPoints())) dataArrayList.add(d);
            }
            if (wonHistoryAdapter != null) wonHistoryAdapter.notifyDataSetChanged();
            int visibility = dataArrayList.isEmpty() ? View.VISIBLE : View.GONE;
            emptyImage.setVisibility(visibility);
            tvNoData.setVisibility(visibility);
        } else if (his == 300 || his == 400) {
            slWonModelList.clear();
            for (DataStarlineWin.Data d : fullSlWonModelList) {
                if (matchesFilter(d.getGameName(), d.getWinPoints(), d.getBidPoints())) slWonModelList.add(d);
            }
            if (SLWonHistoryAdapter != null) SLWonHistoryAdapter.notifyDataSetChanged();
            int visibility = slWonModelList.isEmpty() ? View.VISIBLE : View.GONE;
            emptyImage.setVisibility(visibility);
            tvNoData.setVisibility(visibility);
        } else if (his == 500 || his == 600) {
            disaWonModelList.clear();
            for (DataDisawarWin.Data d : fullDisaWonModelList) {
                if (matchesFilter(d.getGameName(), d.getWinPoints(), d.getBidPoints())) disaWonModelList.add(d);
            }
            if (disaWonHistoryAdapter != null) disaWonHistoryAdapter.notifyDataSetChanged();
            int visibility = disaWonModelList.isEmpty() ? View.VISIBLE : View.GONE;
            emptyImage.setVisibility(visibility);
            tvNoData.setVisibility(visibility);
        }
    }

    private boolean matchesFilter(String market, String winPoints, String bidPoints) {
        if (!filterMarket.equals("All Markets") && !market.equals(filterMarket)) return false;
        
        if (filterStatus.equals("All")) return true;
        
        int win = 0;
        try { win = Integer.parseInt(winPoints); } catch (Exception ignored) {}
        
        if (filterStatus.equals("Win")) return win > 0;
        if (filterStatus.equals("Loss")) return win == 0 && (bidPoints != null && !bidPoints.equals("0"));
        if (filterStatus.equals("Pending")) return win == 0 && (bidPoints == null || bidPoints.equals("0"));
        
        return true;
    }

    private void fetchHistory(String from, String to) {
        String f = from + " 00:00:00";
        String t = to + " 23:59:59";
        swipeRefreshLayout.setRefreshing(true);
        if (his == 100) call = ApiClass.getClient().HistoryOfWins(SharPrefClass.getLoginInToken(this), f, t);
        else call = ApiClass.getClient().HistoryOfBids(SharPrefClass.getLoginInToken(this), f, t);

        call.enqueue(new Callback<DataWin>() {
            @Override
            public void onResponse(@NonNull Call<DataWin> call, @NonNull Response<DataWin> response) {
                if (response.isSuccessful() && response.body() != null) {
                    DataWin body = response.body();
                    if (body.getStatus().equalsIgnoreCase("success")) {
                        fullDataArrayList = body.getData();
                        recyclerView.setLayoutManager(new LinearLayoutManager(WonHistoryActivity.this));
                        wonHistoryAdapter = new WonHistoryAdapter(WonHistoryActivity.this, dataArrayList);
                        recyclerView.setAdapter(wonHistoryAdapter);
                        filterDataLocally();
                    } else {
                        emptyImage.setVisibility(View.VISIBLE);
                        tvNoData.setVisibility(View.VISIBLE);
                        Toast.makeText(WonHistoryActivity.this, body.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(@NonNull Call<DataWin> call, @NonNull Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                Toast.makeText(WonHistoryActivity.this, "Failed to load data", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void fetchSLHistory(String from, String to) {
        String f = from + " 00:00:00";
        String t = to + " 23:59:59";
        swipeRefreshLayout.setRefreshing(true);
        if (his == 300) sLCall = ApiClass.getClient().HistorySLBids(SharPrefClass.getLoginInToken(this), f, t);
        else sLCall = ApiClass.getClient().starLineBidHistory(SharPrefClass.getLoginInToken(this), f, t);

        sLCall.enqueue(new Callback<DataStarlineWin>() {
            @Override
            public void onResponse(@NonNull Call<DataStarlineWin> call, @NonNull Response<DataStarlineWin> response) {
                if (response.isSuccessful() && response.body() != null) {
                    DataStarlineWin body = response.body();
                    if (body.getStatus().equalsIgnoreCase("success")) {
                        fullSlWonModelList = body.getData();
                        recyclerView.setLayoutManager(new LinearLayoutManager(WonHistoryActivity.this));
                        SLWonHistoryAdapter = new SLWonHistoryAdapter(WonHistoryActivity.this, slWonModelList);
                        recyclerView.setAdapter(SLWonHistoryAdapter);
                        filterDataLocally();
                    } else {
                        emptyImage.setVisibility(View.VISIBLE);
                        Toast.makeText(WonHistoryActivity.this, body.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(@NonNull Call<DataStarlineWin> call, @NonNull Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                Toast.makeText(WonHistoryActivity.this, "Failed to load data", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void fetchDesawarHistory(String from, String to) {
        String f = from + " 00:00:00";
        String t = to + " 23:59:59";
        swipeRefreshLayout.setRefreshing(true);
        if (his == 500) disaCall = ApiClass.getClient().deasawarBidHistory(SharPrefClass.getLoginInToken(this), f, t);
        else disaCall = ApiClass.getClient().desawarWinHistory(SharPrefClass.getLoginInToken(this), f, t);

        disaCall.enqueue(new Callback<DataDisawarWin>() {
            @Override
            public void onResponse(@NonNull Call<DataDisawarWin> call, @NonNull Response<DataDisawarWin> response) {
                if (response.isSuccessful() && response.body() != null) {
                    DataDisawarWin body = response.body();
                    if (body.getStatus().equalsIgnoreCase("success")) {
                        fullDisaWonModelList = body.getData();
                        recyclerView.setLayoutManager(new LinearLayoutManager(WonHistoryActivity.this));
                        disaWonHistoryAdapter = new DisaWonHistoryAdapter(WonHistoryActivity.this, disaWonModelList);
                        recyclerView.setAdapter(disaWonHistoryAdapter);
                        filterDataLocally();
                    } else {
                        emptyImage.setVisibility(View.VISIBLE);
                        Toast.makeText(WonHistoryActivity.this, body.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(@NonNull Call<DataDisawarWin> call, @NonNull Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                Toast.makeText(WonHistoryActivity.this, "Failed to load data", Toast.LENGTH_SHORT).show();
            }
        });
    }

    @Override
    protected void onRestart() {
        super.onRestart();
        registerReceiver(myReceiver, mIntentFilter);
    }

    @Override
    protected void onResume() {
        super.onResume();
        registerReceiver(myReceiver, mIntentFilter);
    }

    @Override
    protected void onPause() {
        super.onPause();
        unregisterReceiver(myReceiver);
    }
}