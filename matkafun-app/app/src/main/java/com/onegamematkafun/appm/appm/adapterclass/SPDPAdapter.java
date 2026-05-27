package com.onegamematkafun.appm.appm.adapterclass;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.onegamematkafun.appm.appm.responseclass.DataPlaying;
import com.kalyankuber.alpha.R;

import java.util.List;

public class SPDPAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {

    public interface OnItemChangeListener {
        void onItemDeleted(int totalPoints);
    }

    private final List<DataPlaying> dataPlayingList;
    private final OnItemChangeListener listener;

    private static final int TYPE_HEADER = 0;
    private static final int TYPE_ITEM = 1;

    public SPDPAdapter(List<DataPlaying> dataPlayingList, OnItemChangeListener listener) {
        this.dataPlayingList = dataPlayingList;
        this.listener = listener;
    }

    @Override
    public int getItemViewType(int position) {
        return (position == 0) ? TYPE_HEADER : TYPE_ITEM;
    }

    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        if (viewType == TYPE_HEADER) {
            View v = LayoutInflater.from(parent.getContext())
                    .inflate(R.layout.item_pana_header, parent, false);
            return new HeaderViewHolder(v);
        } else {
            View v = LayoutInflater.from(parent.getContext())
                    .inflate(R.layout.item_pana, parent, false);
            return new ItemViewHolder(v);
        }
    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, int position) {
        if (holder instanceof ItemViewHolder) {
            // Adjust for header offset
            int realPos = position - 1;
            DataPlaying item = dataPlayingList.get(realPos);
            ItemViewHolder vh = (ItemViewHolder) holder;

            vh.tvDigit.setText(item.getDigit());
            vh.tvPana.setText(item.getPana());
            vh.tvPoints.setText(item.getBid_points());

            vh.btnDelete.setOnClickListener(v -> removeItem(realPos));
        }
    }

    @Override
    public int getItemCount() {
        return dataPlayingList.size() + 1; // +1 for header
    }

    // ✅ Proper deletion handling
    private void removeItem(int index) {
        if (index < 0 || index >= dataPlayingList.size()) return;

        try {
            DataPlaying item = dataPlayingList.get(index);
            int bidPoints = Integer.parseInt(item.getBid_points());

            // Remove item
            dataPlayingList.remove(index);

            // Notify RecyclerView safely
            notifyDataSetChanged();

            // Recalculate total
            int total = 0;
            for (DataPlaying dp : dataPlayingList) {
                try {
                    total += Integer.parseInt(dp.getBid_points());
                } catch (Exception ignored) {}
            }

            // Notify activity of new total
            if (listener != null) listener.onItemDeleted(total);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    // Header holder
    static class HeaderViewHolder extends RecyclerView.ViewHolder {
        public HeaderViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }

    // Item holder
    static class ItemViewHolder extends RecyclerView.ViewHolder {
        TextView tvDigit, tvPana, tvPoints;
        ImageButton btnDelete;

        public ItemViewHolder(@NonNull View itemView) {
            super(itemView);
            tvDigit = itemView.findViewById(R.id.tv_digit);
            tvPana = itemView.findViewById(R.id.tv_pana);
            tvPoints = itemView.findViewById(R.id.tv_points);
            btnDelete = itemView.findViewById(R.id.btn_delete);
        }
    }
}
