package com.onewonderclub.market.adapterclass;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.kalyankuber.alpha.R;
import com.onewonderclub.market.activityclass.WebViewActivity;
import com.onewonderclub.market.responseclass.DataGameList;

import java.util.ArrayList;

public class ChartAdapter extends RecyclerView.Adapter<ChartAdapter.ViewHolder> {

    Context context;
    private final ArrayList<DataGameList.Data> dataArrayList;

    public ChartAdapter(Context context, ArrayList<DataGameList.Data> dataArrayList) {
        this.context = context;
        this.dataArrayList = dataArrayList;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_chart_game, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        DataGameList.Data data = dataArrayList.get(position);
        if (position % 2 == 0) {
            holder.itemView.setBackgroundColor(android.graphics.Color.WHITE);
        } else {
            holder.itemView.setBackgroundColor(android.graphics.Color.parseColor("#F9F9F9"));
        }
        
        holder.tvMarketName.setText(data.getName());
        holder.tvOpenTime.setText(data.getOpen_time());
        holder.tvCloseTime.setText(data.getClose_time());
        
        holder.tvViewChart.setOnClickListener(v -> {
            Intent intent = new Intent(context, WebViewActivity.class);
            intent.putExtra("URL", data.getChart_url());
            intent.putExtra("SHOW_TOOLBAR", true);
            intent.putExtra("TITLE", data.getName() + " Chart");
            context.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return dataArrayList.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvMarketName, tvOpenTime, tvCloseTime, tvViewChart;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvMarketName = itemView.findViewById(R.id.tv_market_name);
            tvOpenTime = itemView.findViewById(R.id.tv_open_time);
            tvCloseTime = itemView.findViewById(R.id.tv_close_time);
            tvViewChart = itemView.findViewById(R.id.tv_view_chart);
        }
    }
}
