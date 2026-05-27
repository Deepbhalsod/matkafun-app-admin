package com.onegamematkafun.market.activityclass;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.imageview.ShapeableImageView;
import com.kalyankuber.alpha.R;
import com.onegamematkafun.market.adapterclass.PurseAdapter;
import com.onegamematkafun.market.apiclass.ApiClass;
import com.onegamematkafun.market.responseclass.DataWalletHistory;
import com.onegamematkafun.market.shareprefclass.SharPrefClass;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class PassbookActivity extends AppCompatActivity {

    private MaterialToolbar toolbar;
    private RecyclerView recyclerView;
    private ShapeableImageView emptyImage;
    private SwipeRefreshLayout swipeRefreshLayout;
    private PurseAdapter purseAdapter;
    private List<DataWalletHistory.Data.Statement> modelWalletArrayList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_passbook);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(getResources().getColor(R.color.matka_blue));

        intVariables();
        toolbarMethod();
        purseStatementMethod();
    }

    private void intVariables() {
        toolbar = findViewById(R.id.toolbar);
        recyclerView = findViewById(R.id.recyclerView);
        emptyImage = findViewById(R.id.emptyImage);
        swipeRefreshLayout = findViewById(R.id.swipe_ref_lyt);
    }

    private void toolbarMethod() {
        toolbar.setTitle(getString(R.string.passbook));
        toolbar.setNavigationOnClickListener(v -> onBackPressed());

        swipeRefreshLayout.setOnRefreshListener(() -> purseStatementMethod());
    }

    private void purseStatementMethod() {
        swipeRefreshLayout.setRefreshing(true);
        Call<DataWalletHistory> call = ApiClass.getClient().purseStatement(SharPrefClass.getLoginInToken(this), "");
        call.enqueue(new Callback<DataWalletHistory>() {
            @Override
            public void onResponse(@NonNull Call<DataWalletHistory> call, @NonNull Response<DataWalletHistory> response) {
                if (response.isSuccessful()) {
                    DataWalletHistory dataWalletHistory = response.body();
                    if (dataWalletHistory != null) {
                        if ("505".equalsIgnoreCase(dataWalletHistory.getCode())) {
                            SharPrefClass.setCleaninfo(PassbookActivity.this);
                            Toast.makeText(PassbookActivity.this, dataWalletHistory.getMessage(), Toast.LENGTH_SHORT).show();
                            Intent intent = new Intent(PassbookActivity.this, SignInActivity.class);
                            startActivity(intent);
                            finish();
                            return;
                        }

                        if ("success".equalsIgnoreCase(dataWalletHistory.getStatus())) {
                            modelWalletArrayList = dataWalletHistory.getData().getStatement();
                            LinearLayoutManager layoutManager = new LinearLayoutManager(PassbookActivity.this);
                            recyclerView.setLayoutManager(layoutManager);
                            purseAdapter = new PurseAdapter(PassbookActivity.this, modelWalletArrayList);
                            recyclerView.setAdapter(purseAdapter);

                            if (modelWalletArrayList.isEmpty()) {
                                recyclerView.setVisibility(View.GONE);
                                emptyImage.setVisibility(View.VISIBLE);
                            } else {
                                recyclerView.setVisibility(View.VISIBLE);
                                emptyImage.setVisibility(View.GONE);
                            }
                        } else {
                            Toast.makeText(PassbookActivity.this, dataWalletHistory.getMessage(), Toast.LENGTH_SHORT).show();
                            recyclerView.setVisibility(View.GONE);
                            emptyImage.setVisibility(View.VISIBLE);
                        }
                    }
                } else {
                    Toast.makeText(PassbookActivity.this, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
                swipeRefreshLayout.setRefreshing(false);
            }

            @Override
            public void onFailure(@NonNull Call<DataWalletHistory> call, @NonNull Throwable t) {
                swipeRefreshLayout.setRefreshing(false);
                Toast.makeText(PassbookActivity.this, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
            }
        });
    }
}
