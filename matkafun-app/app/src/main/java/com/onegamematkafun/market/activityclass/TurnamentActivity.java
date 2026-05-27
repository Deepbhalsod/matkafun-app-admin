package com.onegamematkafun.market.activityclass;

import static com.onegamematkafun.market.shareprefclass.Utility.BroadCastStringForAction;
import static com.onegamematkafun.market.shareprefclass.Utility.myReceiver;

import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.textview.MaterialTextView;
import com.onegamematkafun.market.shareprefclass.Utility;
import com.onegamematkafun.market.shareprefclass.YourService;
import com.onegamematkafun.appm.appm.activityclass.SPDPActivity;
import com.kalyankuber.alpha.R;

public class TurnamentActivity extends AppCompatActivity {

    private MaterialToolbar toolbar;
    private androidx.cardview.widget.CardView sinD, jodD, sinP, douP, triP, haS, fuS, jodDb, sinPb, douPb;

    private Intent intent;
    private MaterialTextView mDataConText;
    private IntentFilter mIntentFilter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_turnament);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(getResources().getColor(R.color.matka_blue));

        intVariables();
        loadData();
        toolbar.setNavigationOnClickListener(v -> onBackPressed());

    }

    private void loadData() {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        intent = new Intent(this, PlayingActivity.class);
        intent.putExtra("open", open);
        intent.putExtra("games", games);
        if(!open){
            sinD.setVisibility(View.VISIBLE);
            hideView(jodD);
            hideView(jodDb);
            sinP.setVisibility(View.VISIBLE);
            douP.setVisibility(View.VISIBLE);
            triP.setVisibility(View.VISIBLE);
            hideView(haS);
            hideView(fuS);
            hideView(findViewById(R.id.half_sb));
            hideView(findViewById(R.id.full_sb));
        }

        Utility utility = new Utility(mDataConText);
        mIntentFilter = new IntentFilter();
        mIntentFilter.addAction(BroadCastStringForAction);
        Intent serviceIntent = new Intent(this, YourService.class);
        startService(serviceIntent);
    }

    private void hideView(View v) {
        if (v != null) {
            v.setVisibility(View.GONE);
            if (v.getParent() instanceof android.widget.GridLayout) {
                ((android.widget.GridLayout) v.getParent()).removeView(v);
            }
        }
    }

    private void intVariables() {
        toolbar = findViewById(R.id.toolbar);
        sinD = findViewById(R.id.singleD);
        sinP = findViewById(R.id.single_p);
        jodD = findViewById(R.id.jodi_d);
        douP = findViewById(R.id.doP);
        haS = findViewById(R.id.half_s);
        triP = findViewById(R.id.tri_p);
        fuS = findViewById(R.id.full_s);
        mDataConText = findViewById(R.id.dataConText);
        
        jodDb = findViewById(R.id.jodi_db);
        sinPb = findViewById(R.id.single_pb);
        douPb = findViewById(R.id.doPb);
        
        sinPb.setOnClickListener(this::singlePanaBulk);
        douPb.setOnClickListener(this::doublePannaBulk);
    }

    public void singleDigit(View view) {
        intent.putExtra(getString(R.string.game_name), 1);
        startActivity(intent);
    }

    public void singleDigitBulk(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        Intent bulkIntent = new Intent(this, SingleDigitBulkActivity.class);
        bulkIntent.putExtra("games", games);
        bulkIntent.putExtra("open", open);
        startActivity(bulkIntent);
    }

    public void spDpTp(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        Intent spDpTpIntent = new Intent(this, SPDPActivity.class);
        spDpTpIntent.putExtra("open", open);
        spDpTpIntent.putExtra("games", games);
        spDpTpIntent.putExtra(getString(R.string.game_name), 8);
        spDpTpIntent.putExtra("motor_type", "SPDPTP"); // Custom flag for new implementation
        startActivity(spDpTpIntent);
    }

    public void spMotor(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        Intent spIntent = new Intent(this, SPDPActivity.class);
        spIntent.putExtra("open", open);
        spIntent.putExtra("games", games);
        spIntent.putExtra(getString(R.string.game_name), 20);
        spIntent.putExtra("motor_type", "SP");
        startActivity(spIntent);
    }

    public void dpMotor(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        Intent dpIntent = new Intent(this, SPDPActivity.class);
        dpIntent.putExtra("open", open);
        dpIntent.putExtra("games", games);
        dpIntent.putExtra(getString(R.string.game_name), 20);
        dpIntent.putExtra("motor_type", "DP");
        startActivity(dpIntent);
    }

    public void jodiDigit(View view) {
        intent.putExtra(getString(R.string.game_name), 2);
        startActivity(intent);
    }
    
    // Original jodiDigitBulk method removed as per user request.

    public void singlePana(View view) {
        intent.putExtra(getString(R.string.game_name), 3);
        startActivity(intent);
    }

    public void singlePanaBulk(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        Intent bulkIntent = new Intent(this, SinglePannaBulkActivity.class);
        bulkIntent.putExtra("games", games);
        bulkIntent.putExtra("open", open);
        startActivity(bulkIntent);
    }

    public void doublePannaBulk(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        Intent bulkIntent = new Intent(this, DoublePannaBulkActivity.class);
        bulkIntent.putExtra("games", games);
        bulkIntent.putExtra("open", open);
        startActivity(bulkIntent);
    }

    public void doublePana(View view) {
        intent.putExtra(getString(R.string.game_name), 4);
        startActivity(intent);
    }

    public void triplePana(View view) {
        intent.putExtra(getString(R.string.game_name), 5);
        startActivity(intent);
    }

    public void halfSangam(View view) {
        intent.putExtra(getString(R.string.game_name), 6);
        startActivity(intent);
    }

    public void fullSangam(View view) {
        intent.putExtra(getString(R.string.game_name), 7);
        startActivity(intent);
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