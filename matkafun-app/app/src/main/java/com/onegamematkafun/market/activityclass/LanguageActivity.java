package com.onegamematkafun.market.activityclass;

import android.content.Context;
import android.content.Intent;
import android.content.res.Configuration;
import android.content.res.Resources;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.card.MaterialCardView;
import com.kalyankuber.alpha.R;
import com.onegamematkafun.market.shareprefclass.SharPrefClass;

import java.util.HashMap;
import java.util.Locale;
import java.util.Map;

public class LanguageActivity extends AppCompatActivity {

    private String selectedLanguageCode = "en"; // Default
    private Map<String, View> languageViews = new HashMap<>();
    private Map<String, String> languageNames = new HashMap<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_language);

        MaterialButton btnContinue = findViewById(R.id.btnContinue);

        setupLanguages();

        btnContinue.setOnClickListener(v -> {
            SharPrefClass.setPrefrenceStrngData(this, SharPrefClass.KEY_SELECTED_LANGUAGE, selectedLanguageCode);
            SharPrefClass.setSharedBooleanStatus(this, SharPrefClass.KEY_IS_LANGUAGE_SET, true);
            
            setLocale(this, selectedLanguageCode);

            // Determine next screen based on login status or flow
            if (SharPrefClass.getsignInSuccess(this)) {
                 Intent intent = new Intent(this, DashboardActivity.class);
                 intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                 startActivity(intent);
            } else {
                 Intent intent = new Intent(this, WelcomeActivity.class);
                 intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                 startActivity(intent);
            }
            finish();
        });
    }

    private void setupLanguages() {
        // Map Include IDs to Language Codes and Display Names
        initLanguageItem(R.id.lang_en, "en", "English");
        initLanguageItem(R.id.lang_hi, "hi", "हिंदी");
        initLanguageItem(R.id.lang_gu, "gu", "ગુજરાતી");
        initLanguageItem(R.id.lang_mr, "mr", "मराठी");
        initLanguageItem(R.id.lang_ta, "ta", "தமிழ்");
        initLanguageItem(R.id.lang_te, "te", "తెలుగు");
        initLanguageItem(R.id.lang_kn, "kn", "ಕನ್ನಡ");
        initLanguageItem(R.id.lang_ml, "ml", "മലയാളം");

        // Pre-select current or default
        String current = SharPrefClass.getPrfrnceinfo(this, SharPrefClass.KEY_SELECTED_LANGUAGE);
        if (current == null) current = "en";
        selectLanguage(current);
    }

    private void initLanguageItem(int viewId, String code, String name) {
        View view = findViewById(viewId);
        TextView tvName = view.findViewById(R.id.langName);
        tvName.setText(name);

        view.setOnClickListener(v -> selectLanguage(code));
        languageViews.put(code, view);
        languageNames.put(code, name);
    }

    private void selectLanguage(String code) {
        selectedLanguageCode = code;

        for (Map.Entry<String, View> entry : languageViews.entrySet()) {
            View view = entry.getValue();
            MaterialCardView card = (MaterialCardView) view;
            ImageView icon = view.findViewById(R.id.selectionIcon);
            TextView text = view.findViewById(R.id.langName);

            if (entry.getKey().equals(code)) {
                card.setStrokeColor(ContextCompat.getColor(this, R.color.primary_color));
                card.setStrokeWidth(4);
                icon.setImageResource(R.drawable.baseline_done_outline_24); 
                icon.setColorFilter(ContextCompat.getColor(this, R.color.primary_color));
                text.setTextColor(ContextCompat.getColor(this, R.color.primary_color));
            } else {
                card.setStrokeColor(0xFFE0E0E0); // Grey
                card.setStrokeWidth(2);
                icon.setImageResource(R.drawable.circle_bg); // Use a circle drawable or similar
                icon.setColorFilter(0xFFE0E0E0);
                text.setTextColor(ContextCompat.getColor(this, R.color.black));
            }
        }
    }

    public static void setLocale(Context context, String languageCode) {
        Locale locale = new Locale(languageCode);
        Locale.setDefault(locale);
        Resources resources = context.getResources();
        Configuration config = resources.getConfiguration();
        config.setLocale(locale);
        resources.updateConfiguration(config, resources.getDisplayMetrics());
    }
}
