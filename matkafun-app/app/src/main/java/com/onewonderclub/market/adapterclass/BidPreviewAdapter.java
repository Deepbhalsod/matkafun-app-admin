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

public class BidPreviewAdapter extends RecyclerView.Adapter<BidPreviewAdapter.ViewHolder> {

    private final List<Map.Entry<Integer, Integer>> bids;
    private final Context context;

    public BidPreviewAdapter(Context context, List<Map.Entry<Integer, Integer>> bids) {
        this.context = context;
        this.bids = bids;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_bid_preview, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Map.Entry<Integer, Integer> entry = bids.get(position);
        holder.tvPreview.setText(entry.getKey() + ": " + entry.getValue() + " pts");
    }

    @Override
    public int getItemCount() {
        return bids.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvPreview;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvPreview = itemView.findViewById(R.id.tv_bid_preview);
        }
    }
}
