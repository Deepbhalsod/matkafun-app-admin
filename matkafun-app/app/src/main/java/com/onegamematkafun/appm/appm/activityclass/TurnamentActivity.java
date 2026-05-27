package com.onegamematkafun.appm.appm.activityclass;

import static com.onegamematkafun.appm.appm.shareprefclass.Utility.BroadCastStringForAction;
import static com.onegamematkafun.appm.appm.shareprefclass.Utility.myReceiver;

import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.textview.MaterialTextView;
import com.kalyankuber.alpha.R;
import com.onegamematkafun.appm.appm.shareprefclass.Utility;
import com.onegamematkafun.appm.appm.shareprefclass.YourService;

public class TurnamentActivity extends AppCompatActivity {

    private MaterialToolbar toolbar;
    private androidx.cardview.widget.CardView autoD, sinD, jodD, sinP, douP, triP, haS, fuS, autoDa, autoDb, autoDc;
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
            autoD.setVisibility(View.VISIBLE);
            autoDa.setVisibility(View.VISIBLE);
            autoDb.setVisibility(View.VISIBLE);
            autoDc.setVisibility(View.VISIBLE);
            hideView(jodD);
            hideView(findViewById(R.id.jodi_db));
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
        autoD = findViewById(R.id.autoDigitsPana);
        autoDa = findViewById(R.id.autoDigitsPanaa);
        autoDb = findViewById(R.id.autoDigitsPanab);
        autoDc = findViewById(R.id.autoDigitsPanac);
        sinP = findViewById(R.id.single_p);
        jodD = findViewById(R.id.jodi_d);
        douP = findViewById(R.id.doP);
        haS = findViewById(R.id.half_s);
        triP = findViewById(R.id.tri_p);
        fuS = findViewById(R.id.full_s);
        mDataConText = findViewById(R.id.dataConText);

        // Additional paired images (redirect to same actions)
        androidx.cardview.widget.CardView singleDb = findViewById(R.id.singleDb);
        androidx.cardview.widget.CardView jodi_db = findViewById(R.id.jodi_db);
        androidx.cardview.widget.CardView single_pb = findViewById(R.id.single_pb);
        androidx.cardview.widget.CardView doPb = findViewById(R.id.doPb);
        androidx.cardview.widget.CardView half_sb = findViewById(R.id.half_sb);
        androidx.cardview.widget.CardView full_sb = findViewById(R.id.full_sb);

        // Set same click actions as their originals
        if (singleDb != null) singleDb.setOnClickListener(this::singleDigit);
        if (jodi_db != null) jodi_db.setOnClickListener(this::jodiDigit);
        if (single_pb != null) single_pb.setOnClickListener(this::singlePana);
        if (doPb != null) doPb.setOnClickListener(this::doublePana);
        if (half_sb != null) half_sb.setOnClickListener(this::halfSangam);
        if (full_sb != null) full_sb.setOnClickListener(this::fullSangam);
    }

    public void singleDigit(View view) {
        intent.putExtra(getString(R.string.game_name), 1);
        startActivity(intent);
    }

    public void autoDigitPana(View view) {
        String games = getIntent().getStringExtra(getString(R.string.game));
        Boolean open = getIntent().getBooleanExtra("open", false);
        intent = new Intent(this, SPDPActivity.class);
        intent.putExtra("open", open);
        intent.putExtra("games", games);
        intent.putExtra(getString(R.string.game_name), 20);
        startActivity(intent);
    }

    public void jodiDigit(View view) {
        intent.putExtra(getString(R.string.game_name), 2);
        startActivity(intent);
    }

    public void singlePana(View view) {
        intent.putExtra(getString(R.string.game_name), 3);
        startActivity(intent);
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