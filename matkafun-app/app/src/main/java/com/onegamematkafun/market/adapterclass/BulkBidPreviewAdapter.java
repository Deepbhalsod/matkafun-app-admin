package com.onegamematkafun.market.adapterclass;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.kalyankuber.alpha.R;
import com.onegamematkafun.market.responseclass.BulkBidPreviewModel;
import java.util.List;

public class BulkBidPreviewAdapter extends RecyclerView.Adapter<BulkBidPreviewAdapter.ViewHolder> {

    private final List<BulkBidPreviewModel> bids;
    private final Context context;
    private final OnItemDeleteListener deleteListener;

    public interface OnItemDeleteListener {
        void onItemDelete(int position);
    }

    public BulkBidPreviewAdapter(Context context, List<BulkBidPreviewModel> bids, OnItemDeleteListener deleteListener) {
        this.context = context;
        this.bids = bids;
        this.deleteListener = deleteListener;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_bulk_bid_preview, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        BulkBidPreviewModel entry = bids.get(position);
        holder.tvPanna.setText(entry.getPanna());
        holder.tvPoints.setText(String.valueOf(entry.getPoints()));
        holder.tvType.setText(entry.getSession());
        
        // The delete button click needs to call listener with current position
        holder.btnDelete.setOnClickListener(v -> {
            if (deleteListener != null) {
                // Use getAdapterPosition() for better accuracy during animations/updates
                int pos = holder.getAdapterPosition();
                if (pos != RecyclerView.NO_POSITION) {
                    deleteListener.onItemDelete(pos);
                }
            }
        });
    }

    @Override
    public int getItemCount() {
        return bids.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvPanna, tvPoints, tvType;
        ImageView btnDelete;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvPanna = itemView.findViewById(R.id.tv_panna);
            tvPoints = itemView.findViewById(R.id.tv_points);
            tvType = itemView.findViewById(R.id.tv_type);
            btnDelete = itemView.findViewById(R.id.btn_delete);
        }
    }
}
