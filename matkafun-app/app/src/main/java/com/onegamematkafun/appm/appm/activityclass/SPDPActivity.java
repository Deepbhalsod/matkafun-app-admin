package com.onegamematkafun.appm.appm.activityclass;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.text.SpannableString;
import android.text.TextUtils;
import android.text.style.ForegroundColorSpan;
import android.text.style.RelativeSizeSpan;
import android.text.style.StyleSpan;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RadioGroup;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.radiobutton.MaterialRadioButton;
import com.google.android.material.textfield.TextInputEditText;
import com.google.android.material.textview.MaterialTextView;
import com.google.gson.Gson;
import com.onegamematkafun.market.adapterclass.BulkBidPreviewAdapter;
import com.onegamematkafun.appm.appm.apiclass.ApiClass;
import com.onegamematkafun.appm.appm.responseclass.DataMain;
import com.onegamematkafun.appm.appm.responseclass.DataPlaying;
import com.onegamematkafun.appm.appm.shareprefclass.MBSFragment;
import com.onegamematkafun.appm.appm.shareprefclass.SharPrefClass;
import com.onegamematkafun.appm.appm.shareprefclass.Utility;
import com.onegamematkafun.appm.appm.shareprefclass.YourService;
import com.kalyankuber.alpha.R;
import com.onegamematkafun.market.responseclass.BulkBidPreviewModel;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SPDPActivity extends AppCompatActivity {

    private TextInputEditText etDigit, etPoints;
    private RecyclerView recyclerView;
    private MaterialTextView tvTotalPoints;
    private MaterialButton btnProceed, btnFullSubmit;
    private com.google.android.material.checkbox.MaterialCheckBox cbSp, cbDp, cbTp;
    private LinearLayout llSpDpTp, llPreviewContainer;

    private ProgressBar progressBar;
    private Utility utility;
    private AlertDialog dialog;
    private int totalPoints = 0;

    private int mTotalCoins = 0;
    private int mCurrentCoins = 0;

    private MaterialToolbar toolbar;
    private MenuItem mCoins;

    private MaterialTextView tvChooseSession;
    private RadioGroup radioGroup;

    private String mGameID;
    private MaterialRadioButton open, close;

    private MaterialTextView mDataConText;

    private final List<DataPlaying> dataPlayingList = new ArrayList<>();
    private final List<BulkBidPreviewModel> previewList = new ArrayList<>();
    private BulkBidPreviewAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_spdp);

        initViews();
        setupTabs();
        setupRecycler();
        setupButtons();
    }

    private void initViews() {
        etDigit = findViewById(R.id.et_digit);
        etDigit = findViewById(R.id.et_digit);
        etPoints = findViewById(R.id.et_points);
        recyclerView = findViewById(R.id.recyclerView);
        tvTotalPoints = findViewById(R.id.tv_total_points);
        btnProceed = findViewById(R.id.btn_proceed);
        btnFullSubmit = findViewById(R.id.btn_full_submit);
        tvChooseSession = findViewById(R.id.tv_choose_session);
        radioGroup = findViewById(R.id.radioGroup);
        open = findViewById(R.id.open);
        close = findViewById(R.id.close);
        mDataConText = findViewById(R.id.dataConText);
        cbSp = findViewById(R.id.cbSp);
        cbDp = findViewById(R.id.cbDp);
        cbTp = findViewById(R.id.cbTp);
        llSpDpTp = findViewById(R.id.llSpDpTp);
        llPreviewContainer = findViewById(R.id.ll_preview_container);

        progressBar = new ProgressBar(this);
        utility = new Utility(mDataConText);

        mGameID = getIntent().getStringExtra("games");
        // Set current date
        Date currentDate = Calendar.getInstance().getTime();
        SimpleDateFormat df = new SimpleDateFormat("dd-MMM-yyyy", Locale.getDefault());
        tvChooseSession.setText(df.format(currentDate));
        toolbar = findViewById(R.id.toolbar);
        toolbar.setTitleTextColor(Color.WHITE);

        String motorType = getIntent().getStringExtra("motor_type");
        if ("SP".equals(motorType)) {
            toolbar.setTitle("SP Motor");
            etDigit.setFilters(new android.text.InputFilter[] { new android.text.InputFilter.LengthFilter(10) });
            etDigit.setHint("Enter 4\u201310 Unique Digits");
        } else if ("DP".equals(motorType)) {
            toolbar.setTitle("DP Motor");
            etDigit.setFilters(new android.text.InputFilter[] { new android.text.InputFilter.LengthFilter(10) });
            etDigit.setHint("Enter 4\u201310 Unique Digits");
        } else if ("SPDPTP".equals(motorType)) {
            toolbar.setTitle("SP DP TP");
            etDigit.setFilters(new android.text.InputFilter[] { new android.text.InputFilter.LengthFilter(1) });
            etDigit.setHint("Enter Digit (0-9)");
            llSpDpTp.setVisibility(View.VISIBLE);
            cbSp.setChecked(true);
        } else {
            toolbar.setTitle("Auto Digits Pana"); // Default
            etDigit.setFilters(new android.text.InputFilter[] { new android.text.InputFilter.LengthFilter(1) });
            etDigit.setHint("Enter Digit (0-9)");
            llSpDpTp.setVisibility(View.VISIBLE);
            cbSp.setChecked(true);
        }
        
        toolbar.setNavigationOnClickListener(v -> onBackPressed());

        etDigit.addTextChangedListener(new android.text.TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {}
            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {}
            @Override
            public void afterTextChanged(android.text.Editable s) {
                String motorType = getIntent().getStringExtra("motor_type");
                if ("SP".equals(motorType) || "DP".equals(motorType)) {
                    String str = s.toString();
                    if (str.length() > 0) {
                        int cursorPosition = etDigit.getSelectionStart();
                        StringBuilder sb = new StringBuilder();
                        boolean changed = false;
                        for (int i = 0; i < str.length(); i++) {
                            char c = str.charAt(i);
                            if (sb.indexOf(String.valueOf(c)) == -1) {
                                sb.append(c);
                            } else {
                                changed = true;
                                if (i < cursorPosition) {
                                    cursorPosition--;
                                }
                            }
                        }
                        if (changed) {
                            etDigit.removeTextChangedListener(this);
                            etDigit.setText(sb.toString());
                            etDigit.setSelection(Math.max(0, Math.min(cursorPosition, sb.length())));
                            etDigit.addTextChangedListener(this);
                            Toast.makeText(SPDPActivity.this, "Duplicate digits not allowed", Toast.LENGTH_SHORT).show();
                        }
                    }
                }
            }
        });


        mCoins = toolbar.getMenu().findItem(R.id.coins);
        mCoins.setVisible(true);


        MenuItem mPurse = toolbar.getMenu().findItem(R.id.purse);
        if (mPurse != null) mPurse.setEnabled(false);

        mCurrentCoins = Integer.parseInt(SharPrefClass.getCustomerCoins(SPDPActivity.this));
        setToolBarTitle(mCurrentCoins);


        open.setChecked(true);

        android.widget.Spinner spinnerSession = findViewById(R.id.spinnerSession);
        boolean isOpen = getIntent().getBooleanExtra("open", false);
        List<String> sessionOpts = new ArrayList<>();
        if (isOpen) {
            sessionOpts.add("Open");
        }
        sessionOpts.add("Close");
        ArrayAdapter<String> spinAdapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, sessionOpts);
        spinAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerSession.setAdapter(spinAdapter);

        spinnerSession.setOnItemSelectedListener(new android.widget.AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(android.widget.AdapterView<?> parent, View view, int position, long id) {
                String selected = parent.getItemAtPosition(position).toString();
                if (selected.equals("Open")) open.setChecked(true);
                else close.setChecked(true);

                if (!dataPlayingList.isEmpty() || !previewList.isEmpty()) {
                    dataPlayingList.clear();
                    previewList.clear();
                    if (adapter != null) adapter.notifyDataSetChanged();
                    totalPoints = 0;
                    tvTotalPoints.setText("Total Points : 0");
                    setToolBarTitle(mCurrentCoins);
                    recyclerView.setVisibility(View.GONE);
                    Toast.makeText(SPDPActivity.this, "Session changed. Previous preview cleared.", Toast.LENGTH_SHORT).show();
                }
            }
            @Override
            public void onNothingSelected(android.widget.AdapterView<?> parent) {}
        });
    }

    private void setToolBarTitle(int total) {
        SpannableString s = new SpannableString(String.valueOf(total));
        s.setSpan(new ForegroundColorSpan(Color.WHITE), 0, s.length(), 0);
        s.setSpan(new RelativeSizeSpan(1.50f), 0, s.length(), 0);
        s.setSpan(new StyleSpan(Typeface.BOLD), 0, s.length(), 0);
        if (mCoins != null) {
            mCoins.setTitle(s);
        }
    }

    private void setupTabs() {
        // Obsolete function, replaced by checkboxes logic dynamically evaluated in handleProceed
    }

    private void setupRecycler() {
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        // Adapter is re-initialized on Proceed, but provide an empty shell here.
        adapter = new BulkBidPreviewAdapter(this, previewList, pos -> {
            if (pos >= 0 && pos < dataPlayingList.size()) {
                 DataPlaying item = dataPlayingList.get(pos);
                 int pt = Integer.parseInt(item.getBid_points());
                 totalPoints -= pt;
                 dataPlayingList.remove(pos);
                 previewList.remove(pos);
                 adapter.notifyItemRemoved(pos);
                 tvTotalPoints.setText("Total Points : " + totalPoints);
                 setToolBarTitle(mCurrentCoins - totalPoints);
                 if (dataPlayingList.isEmpty()) {
                     setToolBarTitle(mCurrentCoins);
                     recyclerView.setVisibility(View.GONE);
                 }
            }
        });
        recyclerView.setAdapter(adapter);
    }

    private void setupButtons() {
        btnProceed.setOnClickListener(v -> handleProceed());
        btnFullSubmit.setOnClickListener(v -> {
            if (dataPlayingList.isEmpty()) {
                Toast.makeText(this, "No data to submit!", Toast.LENGTH_SHORT).show();
                return;
            }

            String gsonData = new Gson().toJson(dataPlayingList);
            String serverData = getString(R.string.bids_api_open) + gsonData + getString(R.string.bids_api_close);

            // Confirmation Bottom Sheet like PlayingActivity
            MBSFragment mbsFragment = new MBSFragment(() -> {
                if (YourService.isOnline(SPDPActivity.this))
                    submitToServer(serverData);
                else
                    Toast.makeText(SPDPActivity.this, getString(R.string.check_your_internet_connection), Toast.LENGTH_SHORT).show();
            });
            mbsFragment.show(getSupportFragmentManager(), getString(R.string.bottom_sheet));
            mbsFragment.setCancelable(false);
        });

    }

    private void submitToServer(String serverData) {
        progressBar.setVisibility(View.VISIBLE);

        Call<DataMain> call = ApiClass.getClient().makeoffer(SharPrefClass.getLoginInToken(SPDPActivity.this), serverData);
        call.enqueue(new Callback<DataMain>() {
            @Override
            public void onResponse(Call<DataMain> call, Response<DataMain> response) {
                progressBar.setVisibility(View.GONE);

                if (response.isSuccessful() && response.body() != null) {
                    DataMain dataMain = response.body();

                    // Handle token expiry (505)
                    if ("505".equalsIgnoreCase(dataMain.getCode())) {
                        SharPrefClass.setCleaninfo(SPDPActivity.this);
                        Toast.makeText(SPDPActivity.this, dataMain.getMessage(), Toast.LENGTH_SHORT).show();
                        startActivity(new Intent(SPDPActivity.this, SignInActivity.class));
                        finish();
                        return;
                    }

                    if ("success".equalsIgnoreCase(dataMain.getStatus())) {
                        // Reset local UI after success
                        dataPlayingList.clear();
                        previewList.clear();
                        adapter.notifyDataSetChanged();
                        recyclerView.setVisibility(View.GONE);
                        totalPoints = 0;
                        tvTotalPoints.setText("Total Points : 0");

                        showSuccessDialog(dataMain.getMessage());
                    } else {
                        Toast.makeText(SPDPActivity.this, dataMain.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(SPDPActivity.this, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<DataMain> call, Throwable t) {
                progressBar.setVisibility(View.GONE);
                Toast.makeText(SPDPActivity.this, getString(R.string.on_api_failure), Toast.LENGTH_LONG).show();
                System.out.println("SPDP Bid Submission Failed: " + t);
            }
        });

    }

    public void playAgainBtn(View view) {
        dialog.dismiss();
        etDigit.setText("");
        etPoints.setText("");
        cbSp.setChecked(true);
        cbDp.setChecked(false);
        cbTp.setChecked(false);
    }

    private void showSuccessDialog(String message) {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        LayoutInflater inflater = LayoutInflater.from(this);
        View view = inflater.inflate(R.layout.d_b_layout, null);
        builder.setView(view);
        dialog = builder.create();
        dialog.show();
        dialog.getWindow().setBackgroundDrawableResource(R.drawable.rounded_corner_white);
        dialog.getWindow().setLayout(700, LinearLayout.LayoutParams.WRAP_CONTENT);

        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();

    }


    private void handleProceed() {
        String digitStr = etDigit.getText().toString().trim();
        String pointsStr = etPoints.getText().toString().trim();
        mCurrentCoins = Integer.parseInt(SharPrefClass.getCustomerCoins(SPDPActivity.this));
        totalPoints = 0;

        if (TextUtils.isEmpty(digitStr) || TextUtils.isEmpty(pointsStr)) {
            Toast.makeText(this, "Please enter both Digit and Points", Toast.LENGTH_SHORT).show();
            return;
        }

        int points = Integer.parseInt(pointsStr);
        String motorType = getIntent().getStringExtra("motor_type");
        boolean isMotor = "SP".equals(motorType) || "DP".equals(motorType);
        
        List<String> combinedPannasForBulk = new ArrayList<>();

        if (isMotor) {
            if (digitStr.length() < 4 || digitStr.length() > 10 || !hasUniqueDigits(digitStr)) {
                Toast.makeText(this, "Enter 4\u201310 unique digits", Toast.LENGTH_SHORT).show();
                return;
            }
            combinedPannasForBulk = generateMotorCombinations(digitStr, motorType);
        } else {
            if (!cbSp.isChecked() && !cbDp.isChecked() && !cbTp.isChecked()) {
                Toast.makeText(this, "Please select at least one Panna Type", Toast.LENGTH_SHORT).show();
                return;
            }
            int digit = Integer.parseInt(digitStr);
            if (digit < 0 || digit > 9) {
                Toast.makeText(this, "Digit must be between 0 and 9", Toast.LENGTH_SHORT).show();
                return;
            }
            if (cbSp.isChecked()) combinedPannasForBulk.addAll(getPanaList("SP", digit));
            if (cbDp.isChecked()) combinedPannasForBulk.addAll(getPanaList("DP", digit));
            if (cbTp.isChecked()) combinedPannasForBulk.addAll(getPanaList("TP", digit));
        }

        // ✅ Fetch min/max limits
        int minPoints, maxPoints;
        try {
            minPoints = Integer.parseInt(SharPrefClass.getMaxMinObject(this, SharPrefClass.KEY_MIN_OFFER_SUM));
            maxPoints = Integer.parseInt(SharPrefClass.getMaxMinObject(this, SharPrefClass.KEY_MAX_OFFER_SUM));
        } catch (Exception e) {
            minPoints = 10;
            maxPoints = 100000;
        }

        if (points < minPoints || points > maxPoints) {
            Toast.makeText(this,
                    "Minimum Bid Points " + minPoints + " and Maximum Bid Points " + maxPoints,
                    Toast.LENGTH_LONG).show();
            return;
        }

        int totalNeeded = combinedPannasForBulk.size() * points;
        if (totalNeeded > mCurrentCoins - totalPoints) {
            Toast.makeText(this, "Insufficient Points", Toast.LENGTH_SHORT).show();
            return;
        }

        if (combinedPannasForBulk.isEmpty()) {
            Toast.makeText(this, "No Pana found for this digit!", Toast.LENGTH_SHORT).show();
            return;
        }

        String session = open.isChecked() ? "Open" : "Close";
        String gameId = mGameID;
        
        // Remove clear statements to append new combinations to existing

        // ✅ Loop through Pana numbers
        for (String pana : combinedPannasForBulk) {
            // Avoid duplicates
            boolean exists = false;
            for (BulkBidPreviewModel entry : previewList) {
                if (entry.getPanna().equals(pana) && entry.getSession().equalsIgnoreCase(session)) {
                    exists = true;
                    break;
                }
            }
            if (exists) {
                continue;
            }

            // Detect type dynamically by combination
            String finalPannaType = "single_panna";
            if (isMotor) {
                finalPannaType = "single_digit";
            } else if (pana != null && pana.length() > 2) {
                 char c1 = pana.charAt(0);
                 char c2 = pana.charAt(1);
                 char c3 = pana.charAt(2);
                 if (c1 == c2 && c2 == c3) finalPannaType = "triple_panna";
                 else if (c1 == c2 || c2 == c3 || c1 == c3) finalPannaType = "double_panna";
            }

            DataPlaying model;
            if (open.isChecked()) {
                model = new DataPlaying(
                        gameId,
                        finalPannaType,
                        session,
                        pointsStr,
                        isMotor ? pana : "", "",      
                        !isMotor ? pana : "", "",    
                        pana           
                );
            } else {
                model = new DataPlaying(
                        gameId,
                        finalPannaType,
                        session,
                        pointsStr,
                        "", isMotor ? pana : "",
                        "",
                        !isMotor ? pana : "",
                        pana
                );
            }

            if (isMotor) {
                if ("SP".equals(motorType)) {
                    model.setGame_subtype("sp_motor");
                } else if ("DP".equals(motorType)) {
                    model.setGame_subtype("dp_motor");
                }
            }

            model.setDigit(digitStr);
            dataPlayingList.add(model);
            previewList.add(new BulkBidPreviewModel(pana, points, session));
            totalPoints += points;
        }

        recyclerView.setVisibility(View.VISIBLE);
        llPreviewContainer.setVisibility(View.VISIBLE);
        adapter.notifyDataSetChanged();

        tvTotalPoints.setText("Total Points : " + totalPoints);
        setToolBarTitle(mCurrentCoins - totalPoints);
    }

    private boolean isPannaType(String digits, String targetType) {
        if (digits == null || digits.length() < 3) return false;
        
        char c1 = digits.charAt(0);
        char c2 = digits.charAt(1);
        char c3 = digits.charAt(2);
        
        boolean isTP = (c1 == c2 && c2 == c3);
        boolean isDP = (c1 == c2 || c2 == c3 || c1 == c3) && !isTP;
        boolean isSP = (c1 != c2 && c2 != c3 && c1 != c3);
        
        if ("SP".equals(targetType)) {
            return isSP;
        } else if ("DP".equals(targetType)) {
            return isDP;
        } else if ("TP".equals(targetType)) {
            return isTP;
        }
        return false; 
    }

    private boolean hasUniqueDigits(String str) {
        if (str == null || str.length() < 4 || str.length() > 10) return false;
        for (int i = 0; i < str.length(); i++) {
            for (int j = i + 1; j < str.length(); j++) {
                if (str.charAt(i) == str.charAt(j)) return false;
            }
        }
        return true;
    }

    private List<String> generateMotorCombinations(String input, String type) {
        List<String> results = new ArrayList<>();
        if (input == null || input.length() < 4 || input.length() > 10) return results;

        int n = input.length();
        List<Integer> digits = new ArrayList<>();
        for (char c : input.toCharArray()) {
            digits.add(Character.getNumericValue(c));
        }

        if ("SP".equals(type)) {
            // C(n, 3) — all 3-element combinations with unique digits
            for (int i = 0; i < n; i++) {
                for (int j = i + 1; j < n; j++) {
                    for (int k = j + 1; k < n; k++) {
                        List<Integer> combo = new ArrayList<>();
                        combo.add(digits.get(i));
                        combo.add(digits.get(j));
                        combo.add(digits.get(k));
                        java.util.Collections.sort(combo, (o1, o2) -> {
                            int v1 = (o1 == 0) ? 10 : o1;
                            int v2 = (o2 == 0) ? 10 : o2;
                            return Integer.compare(v1, v2);
                        });
                        results.add("" + combo.get(0) + combo.get(1) + combo.get(2));
                    }
                }
            }
        } else if ("DP".equals(type)) {
            // N x (N-1) — all AAB combinations where A is repeated, B is any other digit
            for (int i = 0; i < n; i++) {
                for (int j = 0; j < n; j++) {
                    if (i != j) {
                        List<Integer> combo = new ArrayList<>();
                        combo.add(digits.get(i));
                        combo.add(digits.get(i));
                        combo.add(digits.get(j));
                        java.util.Collections.sort(combo, (o1, o2) -> {
                            int v1 = (o1 == 0) ? 10 : o1;
                            int v2 = (o2 == 0) ? 10 : o2;
                            return Integer.compare(v1, v2);
                        });
                        results.add("" + combo.get(0) + combo.get(1) + combo.get(2));
                    }
                }
            }
        }
        java.util.Collections.sort(results);
        return results;
    }



    // ✅ Full SP / DP / TP Data
    @SuppressLint("NewApi")
    private List<String> getPanaList(String type, int digit) {
        HashMap<Integer, List<String>> dataMap = new HashMap<>();

        if (type.equals("SP")) {
            dataMap.put(0, List.of("127", "136", "145", "190", "235", "280", "370", "479", "460", "569", "389", "578"));
            dataMap.put(1, List.of("128", "137", "146", "236", "245", "290", "380", "470", "489", "560", "678", "579"));
            dataMap.put(2, List.of("129", "138", "147", "156", "237", "246", "345", "390", "480", "570", "679", "589"));
            dataMap.put(3, List.of("120", "139", "148", "157", "238", "247", "256", "346", "490", "580", "670", "689"));
            dataMap.put(4, List.of("130", "149", "158", "167", "239", "248", "257", "347", "356", "590", "680", "789"));
            dataMap.put(5, List.of("140", "159", "168", "230", "249", "258", "267", "348", "357", "456", "690", "780"));
            dataMap.put(6, List.of("123", "150", "169", "178", "240", "259", "268", "349", "358", "457", "367", "790"));
            dataMap.put(7, List.of("124", "160", "179", "250", "269", "278", "340", "359", "368", "458", "467", "890"));
            dataMap.put(8, List.of("125", "134", "170", "189", "260", "279", "350", "369", "378", "459", "567", "468"));
            dataMap.put(9, List.of("126", "135", "180", "234", "270", "289", "360", "379", "450", "469", "469", "568"));
        } else if (type.equals("DP")) {
            dataMap.put(0, List.of("550", "668", "244", "299", "226", "488", "677", "118", "334"));
            dataMap.put(1, List.of("100", "119", "155", "227", "335", "344", "399", "588", "669"));
            dataMap.put(2, List.of("200", "110", "228", "255", "336", "499", "660", "688", "778"));
            dataMap.put(3, List.of("300", "166", "229", "337", "355", "445", "599", "779", "788"));
            dataMap.put(4, List.of("400", "112", "220", "266", "338", "446", "455", "699", "770"));
            dataMap.put(5, List.of("500", "113", "122", "177", "339", "366", "447", "799", "889"));
            dataMap.put(6, List.of("600", "114", "277", "330", "448", "466", "556", "880", "899"));
            dataMap.put(7, List.of("700", "115", "133", "188", "223", "377", "449", "557", "566"));
            dataMap.put(8, List.of("800", "116", "224", "233", "288", "440", "477", "558", "990"));
            dataMap.put(9, List.of("900", "117", "144", "199", "225", "388", "559", "577", "667"));
        } else if (type.equals("TP")) {
            dataMap.put(0, List.of("000"));
            dataMap.put(1, List.of("777"));
            dataMap.put(2, List.of("222"));
            dataMap.put(3, List.of("444"));
            dataMap.put(4, List.of("888"));
            dataMap.put(5, List.of("555"));
            dataMap.put(6, List.of("222"));
            dataMap.put(7, List.of("999"));
            dataMap.put(8, List.of("666"));
            dataMap.put(9, List.of("333"));
        }

        return dataMap.getOrDefault(digit, new ArrayList<>());
    }
}
