package com.onewonderclub.market.adapterclass;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.kalyankuber.alpha.R;
import java.util.List;
import java.util.Map;

public class SingleDigitBulkAdapter extends RecyclerView.Adapter<SingleDigitBulkAdapter.ViewHolder> {

    private final List<Integer> digits;
    private final Map<Integer, Integer> selectedDigits;
    private final Context context;
    private final OnDigitClickListener listener;

    public interface OnDigitClickListener {
        void onDigitClick(int digit);
    }

    public SingleDigitBulkAdapter(Context context, List<Integer> digits, Map<Integer, Integer> selectedDigits, OnDigitClickListener listener) {
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
        int digit = digits.get(position);
        holder.tvDigit.setText(String.valueOf(digit));

        if (selectedDigits.containsKey(digit)) {
            // Selected: Active style (Teal/White) + Badge
            holder.tvBadgePoints.setVisibility(View.VISIBLE);
            holder.tvBadgePoints.setText(String.valueOf(selectedDigits.get(digit)));
            holder.itemView.setBackgroundResource(R.drawable.bg_chart_btn);
            holder.tvDigit.setTextColor(android.graphics.Color.WHITE);
        } else {
            // Unselected: Default style (Outline/Black) + No Badge
            holder.tvBadgePoints.setVisibility(View.GONE);
            holder.itemView.setBackgroundResource(R.drawable.edittext_outline);
            holder.tvDigit.setTextColor(android.graphics.Color.BLACK);
        }

        holder.itemView.setOnClickListener(v -> listener.onDigitClick(digit));
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
