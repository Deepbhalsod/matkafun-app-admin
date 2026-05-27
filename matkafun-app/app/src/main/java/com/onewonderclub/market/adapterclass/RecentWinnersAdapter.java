package com.onewonderclub.market.adapterclass;

import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.google.android.material.card.MaterialCardView;
import com.kalyankuber.alpha.R;
import com.onewonderclub.market.responseclass.DataTopWinners;
import java.util.List;

public class RecentWinnersAdapter extends RecyclerView.Adapter<RecentWinnersAdapter.ViewHolder> {

    private final Context context;
    private final List<DataTopWinners.Data> list;
    private final String[] colors = {"#00A896", "#E67E22", "#3498DB", "#9B59B6", "#2ECA69", "#E74C3C", "#F1C40F"};

    public RecentWinnersAdapter(Context context, List<DataTopWinners.Data> list) {
        this.context = context;
        this.list = list;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_recent_winner, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        int realPosition = position % list.size();
        DataTopWinners.Data data = list.get(realPosition);

        String username = data.getUsername() != null ? data.getUsername() : "";
        if (username.length() > 4) {
            holder.tvWinnerName.setText("******" + username.substring(username.length() - 4));
        } else {
            holder.tvWinnerName.setText(username);
        }

        holder.tvAvatarLetter.setText(String.valueOf(realPosition + 1));
        
        holder.circleBg.setCardBackgroundColor(Color.parseColor(colors[position % colors.length]));

        String gName = data.getGameName();
        if (gName == null || gName.trim().isEmpty()) {
            gName = "FREE PLAY";
        } else {
            gName = gName.toUpperCase();
        }

        String gType = data.getGameType();
        if (gType == null || gType.trim().isEmpty()) {
            gType = "Bonus";
        }
        
        // Capitalize first letter of game type
        if(gType.length() >= 1) {
            gType = gType.substring(0, 1).toUpperCase() + gType.substring(1).toLowerCase();
        }
        
        holder.tvGameDetails.setText(gName + " • " + gType);
        holder.tvWinAmount.setText("₹" + data.getWinAmount());
    }

    @Override
    public int getItemCount() {
        return list == null || list.isEmpty() ? 0 : Integer.MAX_VALUE; // Infinite scroll
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvAvatarLetter, tvWinnerName, tvGameDetails, tvWinAmount;
        MaterialCardView circleBg;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvAvatarLetter = itemView.findViewById(R.id.tvAvatarLetter);
            tvWinnerName = itemView.findViewById(R.id.tvWinnerName);
            tvGameDetails = itemView.findViewById(R.id.tvGameDetails);
            tvWinAmount = itemView.findViewById(R.id.tvWinAmount);
            circleBg = itemView.findViewById(R.id.circleBg);
        }
    }
}
