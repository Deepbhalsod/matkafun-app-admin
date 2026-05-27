package com.onewonderclub.market.activityclass;

import android.content.Intent;
import android.graphics.Color;
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

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.button.MaterialButton;
import com.google.gson.Gson;
import com.kalyankuber.alpha.R;
import com.onewonderclub.market.adapterclass.BulkBidPreviewAdapter;
import com.onewonderclub.market.adapterclass.BulkGameAdapter;
import com.onewonderclub.market.apiclass.ApiClass;
import com.onewonderclub.market.responseclass.DataMain;
import com.onewonderclub.market.responseclass.DataPlaying;
import com.onewonderclub.market.responseclass.BulkBidPreviewModel;
import com.onewonderclub.market.shareprefclass.MBSFragment;
import com.onewonderclub.market.shareprefclass.SharPrefClass;
import com.onewonderclub.market.shareprefclass.YourService;

import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DoublePannaBulkActivity extends AppCompatActivity implements BulkGameAdapter.OnItemClickListener {

    private TextView tvWalletBalance, tvTotalBids, tvTotalPoints;
    private Spinner spinnerGameType;
    private EditText etPoints;
    private RecyclerView rvDigits, rvBidsPreview;
    private MaterialButton btnSubmit;
    private ProgressBar progressBar;
    private MaterialToolbar toolbar;

    private int currentWalletBalance = 0;
    private String gameId;
    private boolean isMarketOpen;

    private final Map<String, Integer> selectedBids = new HashMap<>(); // Panna -> Points
    private final List<String> digitButtons = new ArrayList<>();
    private BulkGameAdapter digitsAdapter;
    private BulkBidPreviewAdapter previewAdapter;
    private List<BulkBidPreviewModel> previewList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_single_digit_bulk);

        gameId = getIntent().getStringExtra("games");
        isMarketOpen = getIntent().getBooleanExtra("open", false);

        initViews();
        setupGameTypeSpinner();
        populateDigitButtons();
        setupDigitsGrid();
        setupPreviewList();
        updateWalletBalance();

        if (toolbar != null) {
            toolbar.setTitle("Double Panna Bulk");
            if (toolbar.getNavigationIcon() != null) {
                toolbar.getNavigationIcon().setTint(Color.BLACK);
            }
            toolbar.setNavigationOnClickListener(v -> onBackPressed());
        }
    }

    private void populateDigitButtons() {
        digitButtons.clear();
        for (int i = 1; i <= 9; i++) {
            digitButtons.add(String.valueOf(i));
        }
        digitButtons.add("0"); // 0 comes last
    }

    private void initViews() {
        toolbar = findViewById(R.id.toolbar);
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
                    Toast.makeText(DoublePannaBulkActivity.this, "Session changed. Previous preview cleared.", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onNothingSelected(android.widget.AdapterView<?> parent) {}
        });
    }

    private void setupDigitsGrid() {
        rvDigits.setLayoutManager(new GridLayoutManager(this, 5)); // 5 columns
        // Use generator mode, pass empty map
        digitsAdapter = new BulkGameAdapter(this, digitButtons, new HashMap<>(), this);
        rvDigits.setAdapter(digitsAdapter);
    }

    private void setupPreviewList() {
        rvBidsPreview.setLayoutManager(new androidx.recyclerview.widget.LinearLayoutManager(this));
        previewAdapter = new BulkBidPreviewAdapter(this, previewList, this::onDeleteItem);
        rvBidsPreview.setAdapter(previewAdapter);
    }
    
    private void onDeleteItem(int position) {
        if (position >= 0 && position < previewList.size()) {
            String panna = previewList.get(position).getPanna();
            selectedBids.remove(panna);
            updateUI();
        }
    }

    private void updateWalletBalance() {
        String coins = SharPrefClass.getCustomerCoins(this);
        if (coins != null) {
            currentWalletBalance = Integer.parseInt(coins);
            tvWalletBalance.setText(coins);
        }
    }

    @Override
    public void onItemClick(String digitStr) {
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

        // Clear previous selections
        // selectedBids.clear(); // Commented out to allow adding bids instead of replacing

        int digit = Integer.parseInt(digitStr);
        List<String> doublePannas = generateDoublePannas(digit);
        
        for (String panna : doublePannas) {
            selectedBids.put(panna, points);
        }

        updateUI();
        if (doublePannas.isEmpty()) {
            Toast.makeText(this, "No Double Pannas found for digit " + digitStr, Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(this, doublePannas.size() + " bids added for digit " + digitStr, Toast.LENGTH_SHORT).show();
        }
    }
    
    private List<String> generateDoublePannas(int targetDigit) {
        List<String> pannas = new ArrayList<>();
        // Double Panna: Two digits same, one different.
        // Sum % 10 == targetDigit.
        
        for (int a = 0; a <= 9; a++) {
            for (int b = a; b <= 9; b++) { // allow a==b
               // We need 3 digits where 2 are same.
               // Combinations: (a, a, b) or (a, b, b) where a != b.
               // But loop order a <= b covers cases.
               // If a == b, we need a 3rd digit c which is DIFFERENT? No, 3 same is Triple Panna.
               // Double Panna definition: Exactly 2 digits are same.
               
               // Let's iterate all 3 digit combinations and check constraints
            }
        }
        
        // Simpler loop: iterate all valid PANNA combinations (sorted 3 digits) and check type
        for (int a = 0; a <= 9; a++) {
            for (int b = a; b <= 9; b++) {
                for (int c = b; c <= 9; c++) {
                    // Check if it is double panna
                    boolean isDouble = (a == b && b != c) || (a != b && b == c);
                    // (a == c) implies a=b=c since sorted, which is Triple.
                    
                    if (isDouble) {
                        int sum = a + b + c;
                        if (sum % 10 == targetDigit) {
                             List<Integer> d = new ArrayList<>();
                             d.add(a); d.add(b); d.add(c);
                             Collections.sort(d, (o1, o2) -> {
                                  int v1 = (o1 == 0) ? 10 : o1;
                                  int v2 = (o2 == 0) ? 10 : o2;
                                  return Integer.compare(v1, v2);
                             });
                             pannas.add("" + d.get(0) + d.get(1) + d.get(2));
                        }
                    }
                }
            }
        }
        return pannas;
    }

    private void updateUI() {
        previewList.clear();
        List<String> sortedKeys = new ArrayList<>(selectedBids.keySet());
        Collections.sort(sortedKeys);
        
        String session = spinnerGameType.getSelectedItem().toString(); // "Open" or "Close"
        
        for (String key : sortedKeys) {
            previewList.add(new BulkBidPreviewModel(key, selectedBids.get(key), session));
        }
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
            Toast.makeText(this, "Please select at least one Panna", Toast.LENGTH_SHORT).show();
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
        String gameType = "double_panna";

        for (Map.Entry<String, Integer> entry : selectedBids.entrySet()) {
            String panna = entry.getKey();
            String points = String.valueOf(entry.getValue());
            
            if (session.equalsIgnoreCase("Open")) {
                bids.add(new DataPlaying(gameId, gameType, "Open", points, "", "", panna, ""));
            } else {
                bids.add(new DataPlaying(gameId, gameType, "Close", points, "", "", "", panna));
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
                         SharPrefClass.setCleaninfo(DoublePannaBulkActivity.this);
                         Toast.makeText(DoublePannaBulkActivity.this, data.getMessage(), Toast.LENGTH_SHORT).show();
                         Intent intent = new Intent(DoublePannaBulkActivity.this, SignInActivity.class);
                         startActivity(intent);
                         finishAffinity();
                         return;
                     }
                     if (data.getStatus().equals("success")) {
                         SharPrefClass.setUserCoins(DoublePannaBulkActivity.this, String.valueOf(currentWalletBalance - totalDeduction));
                         updateWalletBalance();
                         selectedBids.clear();
                         updateUI();
                         etPoints.setText("");
                         showSuccessDialog();
                     } else {
                         Toast.makeText(DoublePannaBulkActivity.this, data.getMessage(), Toast.LENGTH_SHORT).show();
                     }
                 } else {
                     Toast.makeText(DoublePannaBulkActivity.this, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                 }
             }

             @Override
             public void onFailure(Call<DataMain> call, Throwable t) {
                 progressBar.setVisibility(View.GONE);
                 Toast.makeText(DoublePannaBulkActivity.this, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
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
