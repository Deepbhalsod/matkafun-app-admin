package com.onewonderclub.market.adapterclass;

import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.kalyankuber.alpha.R;
import java.util.List;
import java.util.Map;

public class BulkGameAdapter extends RecyclerView.Adapter<BulkGameAdapter.ViewHolder> {

    private final List<String> digits;
    private final Map<String, Integer> selectedDigits;
    private final Context context;
    private final OnItemClickListener listener;

    public interface OnItemClickListener {
        void onItemClick(String digit);
    }

    public BulkGameAdapter(Context context, List<String> digits, Map<String, Integer> selectedDigits, OnItemClickListener listener) {
        this.context = context;
        this.digits = digits;
        this.selectedDigits = selectedDigits;
        this.listener = listener;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_digit_bulk, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        String digit = digits.get(position);
        holder.tvDigit.setText(digit);

        // Always show as active/selected button style for generator mode
        holder.tvBadgePoints.setVisibility(View.GONE);
        holder.itemView.setBackgroundResource(R.drawable.bg_chart_btn);
        holder.tvDigit.setTextColor(Color.WHITE);

        holder.itemView.setOnClickListener(v -> listener.onItemClick(digit));
    }

    @Override
    public int getItemCount() {
        return digits.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvDigit, tvBadgePoints;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvDigit = itemView.findViewById(R.id.tv_digit);
            tvBadgePoints = itemView.findViewById(R.id.tv_badge_points);
        }
    }
}
