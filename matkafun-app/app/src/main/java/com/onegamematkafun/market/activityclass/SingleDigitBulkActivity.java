package com.onegamematkafun.market.activityclass;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.button.MaterialButton;
import com.google.gson.Gson;
import com.onegamematkafun.market.adapterclass.BidPreviewAdapter;
import com.onegamematkafun.market.adapterclass.SingleDigitBulkAdapter;
import com.onegamematkafun.market.apiclass.ApiClass;
import com.onegamematkafun.market.responseclass.DataMain;
import com.onegamematkafun.market.responseclass.DataPlaying;
import com.onegamematkafun.market.shareprefclass.MBSFragment;
import com.onegamematkafun.market.shareprefclass.SharPrefClass;
import com.onegamematkafun.market.shareprefclass.YourService;
import com.kalyankuber.alpha.R;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SingleDigitBulkActivity extends AppCompatActivity implements SingleDigitBulkAdapter.OnDigitClickListener {

    private TextView tvWalletBalance, tvTotalBids, tvTotalPoints;
    private Spinner spinnerGameType;
    private EditText etPoints;
    private RecyclerView rvDigits, rvBidsPreview;
    private MaterialButton btnSubmit;
    private ProgressBar progressBar;

    private int currentWalletBalance = 0;
    private String gameId;
    private boolean isMarketOpen;

    private final Map<Integer, Integer> selectedBids = new HashMap<>(); // Digit -> Points
    private final List<Integer> digitList = Arrays.asList(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
    private SingleDigitBulkAdapter digitsAdapter;
    private BidPreviewAdapter previewAdapter;
    private List<Map.Entry<Integer, Integer>> previewList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_single_digit_bulk);

        gameId = getIntent().getStringExtra("games");
        isMarketOpen = getIntent().getBooleanExtra("open", false);

        initViews();
        setupGameTypeSpinner();
        setupDigitsGrid();
        setupPreviewList();
        updateWalletBalance();

        findViewById(R.id.toolbar).setOnClickListener(v -> onBackPressed());
    }

    private void initViews() {
        tvWalletBalance = findViewById(R.id.tv_wallet_balance);
        tvTotalBids = findViewById(R.id.tv_total_bids);
        tvTotalPoints = findViewById(R.id.tv_total_points);
        spinnerGameType = findViewById(R.id.spinner_game_type);
        etPoints = findViewById(R.id.et_points);
        rvDigits = findViewById(R.id.rv_digits);
        rvBidsPreview = findViewById(R.id.rv_bids_preview);
        btnSubmit = findViewById(R.id.btn_submit);
        progressBar = findViewById(R.id.progressBar);

        btnSubmit.setOnClickListener(v -> onSubmitClick());
    }

    private void setupGameTypeSpinner() {
        List<String> gameTypes = new ArrayList<>();
        if (!isMarketOpen) {
             gameTypes.clear();
             gameTypes.add("Close");
        } else {
             gameTypes.add("Open");
             gameTypes.add("Close");
        }

        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, gameTypes);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerGameType.setAdapter(adapter);

        spinnerGameType.setOnItemSelectedListener(new android.widget.AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(android.widget.AdapterView<?> parent, View view, int position, long id) {
                if (!selectedBids.isEmpty()) {
                    // Clear preview when session changes to prevent cross-session bid leakage
                    selectedBids.clear();
                    updateUI();
                    etPoints.setText("");
                    Toast.makeText(SingleDigitBulkActivity.this, "Session changed. Previous preview cleared.", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onNothingSelected(android.widget.AdapterView<?> parent) {}
        });
    }

    private void setupDigitsGrid() {
        rvDigits.setLayoutManager(new GridLayoutManager(this, 5));
        digitsAdapter = new SingleDigitBulkAdapter(this, digitList, selectedBids, this);
        rvDigits.setAdapter(digitsAdapter);
    }

    private void setupPreviewList() {
        rvBidsPreview.setLayoutManager(new GridLayoutManager(this, 3));
        previewAdapter = new BidPreviewAdapter(this, previewList);
        rvBidsPreview.setAdapter(previewAdapter);
    }

    private void updateWalletBalance() {
        String coins = SharPrefClass.getCustomerCoins(this);
        currentWalletBalance = Integer.parseInt(coins);
        tvWalletBalance.setText(coins);
    }

    @Override
    public void onDigitClick(int digit) {
        String pointsStr = etPoints.getText().toString().trim();
        if (TextUtils.isEmpty(pointsStr)) {
            Toast.makeText(this, "Please enter points first", Toast.LENGTH_SHORT).show();
            return;
        }

        int points = Integer.parseInt(pointsStr);
        if (points <= 0) {
            Toast.makeText(this, "Points must be greater than 0", Toast.LENGTH_SHORT).show();
            return;
        }
        
        int minPoints = Integer.parseInt(SharPrefClass.getMaxMinObject(this, SharPrefClass.KEY_MIN_OFFER_SUM));
        int maxPoints = Integer.parseInt(SharPrefClass.getMaxMinObject(this, SharPrefClass.KEY_MAX_OFFER_SUM));

        if (points < minPoints || points > maxPoints) {
             Toast.makeText(this, "Points must be between " + minPoints + " and " + maxPoints, Toast.LENGTH_SHORT).show();
             return;
        }
        
        // Logic: Toggle or Update
        if (selectedBids.containsKey(digit)) {
            if (selectedBids.get(digit) == points) {
                // If same points, toggle off
                selectedBids.remove(digit);
            } else {
                // Update points
                selectedBids.put(digit, points);
            }
        } else {
            selectedBids.put(digit, points);
        }

        updateUI();
    }

    private void updateUI() {
        digitsAdapter.notifyDataSetChanged();

        previewList.clear();
        previewList.addAll(selectedBids.entrySet());
        previewAdapter.notifyDataSetChanged();

        int totalBidsCount = selectedBids.size();
        int totalPointsValue = 0;
        for (int p : selectedBids.values()) {
            totalPointsValue += p;
        }

        tvTotalBids.setText(String.valueOf(totalBidsCount));
        tvTotalPoints.setText(String.valueOf(totalPointsValue));
    }

    private void onSubmitClick() {
        if (selectedBids.isEmpty()) {
            Toast.makeText(this, "Please select at least one digit", Toast.LENGTH_SHORT).show();
            return;
        }

        int totalPointsRequired = 0;
        for (int points : selectedBids.values()) {
            totalPointsRequired += points;
        }

        if (totalPointsRequired > currentWalletBalance) {
            Toast.makeText(this, "Insufficient Balance", Toast.LENGTH_SHORT).show();
            return;
        }

        // Prepare Data
        List<DataPlaying> bids = new ArrayList<>();
        String session = spinnerGameType.getSelectedItem().toString(); // "Open" or "Close"
        String gameType = "single_digit"; // Matching API expected type

        for (Map.Entry<Integer, Integer> entry : selectedBids.entrySet()) {
            String digit = String.valueOf(entry.getKey());
            String points = String.valueOf(entry.getValue());
            
            if (session.equalsIgnoreCase("Open")) {
                bids.add(new DataPlaying(gameId, gameType, "Open", points, digit, "", "", ""));
            } else {
                bids.add(new DataPlaying(gameId, gameType, "Close", points, "", digit, "", ""));
            }
        }

        String gsonData = new Gson().toJson(bids);
        String serverData = getString(R.string.bids_api_open) + gsonData + getString(R.string.bids_api_close);

        final int finalTotalPoints = totalPointsRequired;
        MBSFragment mbsFragment = new MBSFragment(() -> {
            if (YourService.isOnline(this)) {
                submitToServer(serverData, finalTotalPoints);
            } else {
                Toast.makeText(this, getString(R.string.check_your_internet_connection), Toast.LENGTH_SHORT).show();
            }
        });
        mbsFragment.show(getSupportFragmentManager(), getString(R.string.bottom_sheet));
        mbsFragment.setCancelable(false);
    }

    private void submitToServer(String serverData, int totalDeduction) {
         progressBar.setVisibility(View.VISIBLE);
         Call<DataMain> call = ApiClass.getClient().makeoffer(SharPrefClass.getLoginInToken(this), serverData);
         call.enqueue(new Callback<DataMain>() {
             @Override
             public void onResponse(Call<DataMain> call, Response<DataMain> response) {
                 progressBar.setVisibility(View.GONE);
                 if (response.isSuccessful() && response.body() != null) {
                     DataMain data = response.body();
                     if (data.getCode().equalsIgnoreCase("505")) {
                         SharPrefClass.setCleaninfo(SingleDigitBulkActivity.this);
                         Toast.makeText(SingleDigitBulkActivity.this, data.getMessage(), Toast.LENGTH_SHORT).show();
                         Intent intent = new Intent(SingleDigitBulkActivity.this, SignInActivity.class);
                         startActivity(intent);
                         finishAffinity();
                         return;
                     }
                     if (data.getStatus().equals("success")) {
                         SharPrefClass.setUserCoins(SingleDigitBulkActivity.this, String.valueOf(currentWalletBalance - totalDeduction));
                         updateWalletBalance();
                         
                         // Clear selections
                         selectedBids.clear();
                         updateUI();
                         etPoints.setText("");
                         
                         showSuccessDialog();
                     }
                     Toast.makeText(SingleDigitBulkActivity.this, data.getMessage(), Toast.LENGTH_SHORT).show();
                 } else {
                     Toast.makeText(SingleDigitBulkActivity.this, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                 }
             }

             @Override
             public void onFailure(Call<DataMain> call, Throwable t) {
                 progressBar.setVisibility(View.GONE);
                 Toast.makeText(SingleDigitBulkActivity.this, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
             }
         });
    }

    private AlertDialog successDialog;

    private void showSuccessDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        LayoutInflater inflater = LayoutInflater.from(this);
        View view = inflater.inflate(R.layout.d_b_layout, null);
        builder.setView(view);
        successDialog = builder.create();
        successDialog.show();
        if (successDialog.getWindow() != null) {
             successDialog.getWindow().setBackgroundDrawableResource(R.drawable.rounded_corner_white);
        }
    }

    public void playAgainBtn(View view) {
        if (successDialog != null && successDialog.isShowing()) {
            successDialog.dismiss();
        }
    }
}
