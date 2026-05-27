package com.onewonderclub.market.adapterclass;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.kalyankuber.alpha.R;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

public class JodiSuggestionAdapter extends RecyclerView.Adapter<JodiSuggestionAdapter.ViewHolder> {

    private final List<String> jodiList;
    private final Context context;
    private final Set<String> selectedJodis = new HashSet<>();

    public JodiSuggestionAdapter(Context context, List<String> jodiList) {
        this.context = context;
        this.jodiList = jodiList;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_jodi_suggestion, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        String jodi = jodiList.get(position);
        holder.tvJodi.setText(jodi);
        
        if (selectedJodis.contains(jodi)) {
            holder.cardView.setCardBackgroundColor(context.getResources().getColor(R.color.warn_red));
        } else {
            holder.cardView.setCardBackgroundColor(context.getResources().getColor(R.color.primary_color));
        }

        holder.itemView.setOnClickListener(v -> {
            if (selectedJodis.contains(jodi)) {
                selectedJodis.remove(jodi);
            } else {
                selectedJodis.add(jodi);
            }
            notifyItemChanged(position);
        });
    }

    public Set<String> getSelectedJodis() {
        return selectedJodis;
    }

    public void clearSelections() {
        selectedJodis.clear();
        notifyDataSetChanged();
    }

    @Override
    public int getItemCount() {
        return jodiList.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvJodi;
        com.google.android.material.card.MaterialCardView cardView;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvJodi = itemView.findViewById(R.id.tv_jodi);
            cardView = (com.google.android.material.card.MaterialCardView) itemView;
        }
    }
}

