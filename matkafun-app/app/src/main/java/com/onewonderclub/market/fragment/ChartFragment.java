package com.onewonderclub.market.fragment;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.kalyankuber.alpha.R;
import com.onewonderclub.market.adapterclass.ChartAdapter;
import com.onewonderclub.market.apiclass.ApiClass;
import com.onewonderclub.market.responseclass.DataGameList;
import com.onewonderclub.market.shareprefclass.SharPrefClass;

import java.util.ArrayList;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ChartFragment extends Fragment {

    private RecyclerView recyclerView;
    private ChartAdapter adapter;
    private ArrayList<DataGameList.Data> gameList = new ArrayList<>();
    private Context context;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_chart, container, false);
        context = view.getContext();

        recyclerView = view.findViewById(R.id.recyclerView_chart);
        recyclerView.setLayoutManager(new LinearLayoutManager(context));
        adapter = new ChartAdapter(context, gameList);
        recyclerView.setAdapter(adapter);

        getGameListMethod();

        return view;
    }

    private void getGameListMethod() {
        Call<DataGameList> call = ApiClass.getClient().MainTournamentList(SharPrefClass.getLoginInToken(context), "");
        call.enqueue(new Callback<DataGameList>() {
            @Override
            public void onResponse(@NonNull Call<DataGameList> call, @NonNull Response<DataGameList> response) {
                if (response.isSuccessful() && response.body() != null) {
                    DataGameList dataGameList = response.body();
                    if (dataGameList.getStatus().equalsIgnoreCase(getString(R.string.success))) {
                        gameList.clear();
                        gameList.addAll(dataGameList.getData());
                        adapter.notifyDataSetChanged();
                    } else {
                         Toast.makeText(context, dataGameList.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(context, getString(R.string.response_error), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<DataGameList> call, Throwable t) {
                Toast.makeText(context, getString(R.string.on_api_failure), Toast.LENGTH_SHORT).show();
            }
        });
    }
}
