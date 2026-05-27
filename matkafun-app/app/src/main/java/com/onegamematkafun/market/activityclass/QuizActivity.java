package com.onegamematkafun.market.activityclass;

import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.kalyankuber.alpha.R;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

public class QuizActivity extends AppCompatActivity {

    private View homeScreen, quizScreen, resultScreen, leaderboardScreen;
    private TextView userRating, totalScore, quizzesCompleted;
    private TextView questionNumber, questionText, currentScoreText;
    private LinearLayout optionsContainer;
    private Button nextBtn;
    private RecyclerView leaderboardList, categoriesRecyclerView;

    private TextView navHomeLabel, navLeaderboardLabel;
    private TextView navHomeIcon, navLeaderboardIcon;

    private List<Category> categories = new ArrayList<>();
    private List<Question> currentQuestions = new ArrayList<>();
    private int currentQuestionIndex = 0;
    private int score = 0;
    private boolean answered = false;
    private String currentCategoryId = "";

    private UserData userData;
    private List<Player> leaderboard = new ArrayList<>();

    private static final String QUIZ_PREFS = "quiz_data_prefs";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_quiz);

        Window window = getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(Color.parseColor("#0F172A")); // Navy 900

        initViews();
        initData();
        setupCategories();
        showScreen("home");
    }

    private void initViews() {
        homeScreen = findViewById(R.id.homeScreen);
        quizScreen = findViewById(R.id.quizScreen);
        resultScreen = findViewById(R.id.resultScreen);
        leaderboardScreen = findViewById(R.id.leaderboardScreen);

        userRating = findViewById(R.id.userRating);
        totalScore = findViewById(R.id.totalScore);
        quizzesCompleted = findViewById(R.id.quizzesCompleted);

        questionNumber = findViewById(R.id.questionNumber);
        questionText = findViewById(R.id.questionText);
        currentScoreText = findViewById(R.id.currentScoreText);
        optionsContainer = findViewById(R.id.optionsContainer);
        nextBtn = findViewById(R.id.nextBtn);

        leaderboardList = findViewById(R.id.leaderboardList);
        leaderboardList.setLayoutManager(new LinearLayoutManager(this));

        categoriesRecyclerView = findViewById(R.id.categoriesRecyclerView);
        categoriesRecyclerView.setLayoutManager(new androidx.recyclerview.widget.GridLayoutManager(this, 2));

        navHomeLabel = findViewById(R.id.navHomeLabel);
        navLeaderboardLabel = findViewById(R.id.navLeaderboardLabel);
        navHomeIcon = findViewById(R.id.navHomeIcon);
        navLeaderboardIcon = findViewById(R.id.navLeaderboardIcon);

        findViewById(R.id.navHome).setOnClickListener(v -> showScreen("home"));
        findViewById(R.id.navLeaderboard).setOnClickListener(v -> showScreen("leaderboard"));

        nextBtn.setOnClickListener(v -> {
            currentQuestionIndex++;
            if (currentQuestionIndex < 5) {
                loadQuestion();
            } else {
                showResults();
            }
        });
    }

    private void initData() {
        categories.add(new Category("history", "History", "⏳", "#F59E0B")); // Amber
        categories.add(new Category("geography", "Geography", "🌍", "#3B82F6")); // Blue
        categories.add(new Category("culture", "Culture", "🎨", "#6366F1")); // Indigo
        categories.add(new Category("sports", "Sports", "🏏", "#10B981")); // Green
        categories.add(new Category("politics", "Politics", "⚖️", "#F43F5E")); // Rose
        categories.add(new Category("science", "Science", "🔬", "#06B6D4")); // Cyan

        loadUserData();
    }

    private void loadUserData() {
        SharedPreferences sp = getSharedPreferences(QUIZ_PREFS, MODE_PRIVATE);
        userData = new UserData();
        userData.totalScore = sp.getInt("totalScore", 0);
        userData.quizzesCompleted = sp.getInt("quizzesCompleted", 0);
        userData.rating = sp.getFloat("rating", 0.0f);

        updateUserStatsViews();

        String lbJson = sp.getString("leaderboard", "");
        if (!lbJson.isEmpty()) {
            try {
                JSONArray array = new JSONArray(lbJson);
                leaderboard.clear();
                for (int i = 0; i < array.length(); i++) {
                    JSONObject obj = array.getJSONObject(i);
                    leaderboard.add(new Player(obj.getString("name"), obj.getInt("score"), obj.getInt("quizzes"), (float) obj.getDouble("rating")));
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        if (leaderboard.isEmpty()) {
            leaderboard.add(new Player("Raj Kumar", 45, 15, 5.0f));
            leaderboard.add(new Player("Priya Sharma", 42, 12, 5.0f));
            leaderboard.add(new Player("Amit Patel", 38, 10, 4.0f));
            leaderboard.add(new Player("Sneha Singh", 35, 9, 4.0f));
            leaderboard.add(new Player("Vikram Joshi", 32, 8, 4.0f));
            saveLeaderboard();
        }
    }

    private void saveUserData() {
        SharedPreferences sp = getSharedPreferences(QUIZ_PREFS, MODE_PRIVATE);
        sp.edit().putInt("totalScore", userData.totalScore)
                .putInt("quizzesCompleted", userData.quizzesCompleted)
                .putFloat("rating", userData.rating)
                .apply();
    }

    private void saveLeaderboard() {
        SharedPreferences sp = getSharedPreferences(QUIZ_PREFS, MODE_PRIVATE);
        try {
            JSONArray array = new JSONArray();
            for (Player p : leaderboard) {
                JSONObject obj = new JSONObject();
                obj.put("name", p.name);
                obj.put("score", p.score);
                obj.put("quizzes", p.quizzes);
                obj.put("rating", p.rating);
                array.put(obj);
            }
            sp.edit().putString("leaderboard", array.toString()).apply();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void updateUserStatsViews() {
        userRating.setText(String.format("%.1f", userData.rating));
        totalScore.setText(String.valueOf(userData.totalScore));
        quizzesCompleted.setText(String.valueOf(userData.quizzesCompleted));
    }

    private void setupCategories() {
        categoriesRecyclerView.setAdapter(new CategoryAdapter(categories));
    }

    class CategoryAdapter extends RecyclerView.Adapter<CategoryAdapter.ViewHolder> {
        private List<Category> cats;
        CategoryAdapter(List<Category> cats) { this.cats = cats; }

        @NonNull
        @Override
        public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
            View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_quiz_category, parent, false);
            return new ViewHolder(view);
        }

        @Override
        public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
            Category cat = cats.get(position);
            holder.layout.setBackgroundColor(Color.parseColor(cat.color));
            holder.icon.setText(cat.icon);
            holder.name.setText(cat.name);
            holder.itemView.setOnClickListener(v -> startQuiz(cat.id));
        }

        @Override
        public int getItemCount() { return cats.size(); }

        class ViewHolder extends RecyclerView.ViewHolder {
            LinearLayout layout;
            TextView icon, name;
            ViewHolder(View v) {
                super(v);
                layout = v.findViewById(R.id.cardLayout);
                icon = v.findViewById(R.id.categoryIcon);
                name = v.findViewById(R.id.categoryName);
            }
        }
    }

    private void startQuiz(String categoryId) {
        currentCategoryId = categoryId;
        currentQuestionIndex = 0;
        score = 0;
        loadQuestionsForCategory(categoryId);
        showScreen("quiz");
        loadQuestion();
    }

    private void loadQuestionsForCategory(String categoryId) {
        currentQuestions.clear();
        if ("history".equals(categoryId)) {
            currentQuestions.add(new Question("Who was the first Prime Minister of India?", new String[]{"Mahatma Gandhi", "Jawaharlal Nehru", "Sardar Patel", "Dr. Rajendra Prasad"}, 1));
            currentQuestions.add(new Question("In which year did India gain independence?", new String[]{"1945", "1947", "1950", "1952"}, 1));
            currentQuestions.add(new Question("Who wrote the Indian National Anthem?", new String[]{"Rabindranath Tagore", "Bankim Chandra", "Sarojini Naidu", "Subhash Chandra Bose"}, 0));
            currentQuestions.add(new Question("The Quit India Movement was launched in which year?", new String[]{"1940", "1942", "1944", "1946"}, 1));
            currentQuestions.add(new Question("Who was known as the Iron Man of India?", new String[]{"Jawaharlal Nehru", "Bhagat Singh", "Sardar Vallabhbhai Patel", "Subhash Chandra Bose"}, 2));
        } else if ("geography".equals(categoryId)) {
            currentQuestions.add(new Question("Which is the longest river in India?", new String[]{"Yamuna", "Ganga", "Godavari", "Brahmaputra"}, 1));
            currentQuestions.add(new Question("How many states are there in India?", new String[]{"28", "29", "30", "31"}, 0));
            currentQuestions.add(new Question("Which is the largest state in India by area?", new String[]{"Maharashtra", "Madhya Pradesh", "Rajasthan", "Uttar Pradesh"}, 2));
            currentQuestions.add(new Question("Where is the Thar Desert located?", new String[]{"Gujarat", "Rajasthan", "Punjab", "Haryana"}, 1));
            currentQuestions.add(new Question("Which is the highest mountain peak in India?", new String[]{"Nanda Devi", "Kanchenjunga", "K2", "Mount Everest"}, 1));
        } else if ("culture".equals(categoryId)) {
            currentQuestions.add(new Question("Which classical dance form originated in Tamil Nadu?", new String[]{"Kathak", "Bharatanatyam", "Odissi", "Manipuri"}, 1));
            currentQuestions.add(new Question("Which festival is known as the Festival of Lights?", new String[]{"Holi", "Diwali", "Dussehra", "Eid"}, 1));
            currentQuestions.add(new Question("Taj Mahal is located in which city?", new String[]{"Delhi", "Jaipur", "Agra", "Lucknow"}, 2));
            currentQuestions.add(new Question("Which is the oldest Veda?", new String[]{"Rig Veda", "Sama Veda", "Yajur Veda", "Atharva Veda"}, 0));
            currentQuestions.add(new Question("Who is known as the Father of Indian Cinema?", new String[]{"Raj Kapoor", "Dadasaheb Phalke", "Satyajit Ray", "V. Shantaram"}, 1));
        } else if ("sports".equals(categoryId)) {
            currentQuestions.add(new Question("Who is known as the God of Cricket?", new String[]{"Virat Kohli", "MS Dhoni", "Sachin Tendulkar", "Kapil Dev"}, 2));
            currentQuestions.add(new Question("In which year did India win its first Cricket World Cup?", new String[]{"1975", "1983", "2007", "2011"}, 1));
            currentQuestions.add(new Question("Which Indian athlete won Gold in Javelin at Tokyo Olympics 2020?", new String[]{"Neeraj Chopra", "PV Sindhu", "Mirabai Chanu", "Bajrang Punia"}, 0));
            currentQuestions.add(new Question("National sport of India is?", new String[]{"Cricket", "Hockey", "Football", "Kabaddi"}, 1));
            currentQuestions.add(new Question("Who was the first Indian to win an individual Olympic Gold medal?", new String[]{"Abhinav Bindra", "Neeraj Chopra", "PV Sindhu", "Karnam Malleswari"}, 0));
        } else if ("politics".equals(categoryId)) {
            currentQuestions.add(new Question("How many fundamental rights are there in Indian Constitution?", new String[]{"5", "6", "7", "8"}, 1));
            currentQuestions.add(new Question("Who is the first citizen of India?", new String[]{"Prime Minister", "President", "Chief Justice", "Speaker"}, 1));
            currentQuestions.add(new Question("When was the Indian Constitution adopted?", new String[]{"26 Jan 1950", "26 Nov 1949", "15 Aug 1947", "26 Jan 1949"}, 1));
            currentQuestions.add(new Question("How many Lok Sabha seats are there?", new String[]{"543", "545", "550", "552"}, 1));
            currentQuestions.add(new Question("Who is known as the Father of Indian Constitution?", new String[]{"Jawaharlal Nehru", "Mahatma Gandhi", "Dr. B.R. Ambedkar", "Sardar Patel"}, 2));
        } else if ("science".equals(categoryId)) {
            currentQuestions.add(new Question("Who is known as the Missile Man of India?", new String[]{"Vikram Sarabhai", "APJ Abdul Kalam", "Homi Bhabha", "CV Raman"}, 1));
            currentQuestions.add(new Question("ISRO headquarters is located in?", new String[]{"Mumbai", "Bangalore", "Hyderabad", "Chennai"}, 1));
            currentQuestions.add(new Question("Which Indian scientist won the Nobel Prize in Physics?", new String[]{"APJ Abdul Kalam", "CV Raman", "Homi Bhabha", "Satyendra Nath Bose"}, 1));
            currentQuestions.add(new Question("What was India's first satellite called?", new String[]{"Aryabhata", "Bhaskara", "INSAT", "Rohini"}, 0));
            currentQuestions.add(new Question("Who founded the Indian Space Research Organisation (ISRO)?", new String[]{"APJ Abdul Kalam", "Vikram Sarabhai", "Homi Bhabha", "CV Raman"}, 1));
        }
    }

    private void loadQuestion() {
        answered = false;
        Question question = currentQuestions.get(currentQuestionIndex);

        questionNumber.setText(String.format("Question %d/5", currentQuestionIndex + 1));
        currentScoreText.setText("Score: " + score);
        questionText.setText(question.question);

        optionsContainer.removeAllViews();
        for (int i = 0; i < question.options.length; i++) {
            Button optionBtn = new Button(this);
            optionBtn.setText(question.options[i]);
            optionBtn.setBackgroundResource(R.drawable.quiz_option_bg);
            optionBtn.setTextColor(Color.WHITE);
            optionBtn.setPadding(30, 30, 30, 30);
            optionBtn.setAllCaps(false);
            optionBtn.setTextSize(16);

            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
            params.setMargins(0, 0, 0, 20);
            optionBtn.setLayoutParams(params);

            int finalI = i;
            optionBtn.setOnClickListener(v -> selectAnswer(finalI));
            optionsContainer.addView(optionBtn);
        }

        nextBtn.setEnabled(false);
        nextBtn.setAlpha(0.5f);
    }

    private void selectAnswer(int selectedIndex) {
        if (answered) return;
        answered = true;

        Question question = currentQuestions.get(currentQuestionIndex);
        for (int i = 0; i < optionsContainer.getChildCount(); i++) {
            Button btn = (Button) optionsContainer.getChildAt(i);
            btn.setEnabled(false);
            btn.setTextColor(Color.WHITE);
            if (i == question.correctIndex) {
                btn.setBackgroundResource(R.drawable.quiz_option_correct);
                btn.setTextColor(Color.WHITE);
            } else if (i == selectedIndex) {
                btn.setBackgroundResource(R.drawable.quiz_option_wrong);
                btn.setTextColor(Color.WHITE);
            }
        }

        if (selectedIndex == question.correctIndex) {
            score++;
            currentScoreText.setText("Score: " + score);
        }

        nextBtn.setEnabled(true);
        nextBtn.setAlpha(1.0f);
    }

    private void showResults() {
        showScreen("result");
        ((TextView)findViewById(R.id.finalScore)).setText(score + "/5");

        String stars = "";
        for (int i = 0; i < 5; i++) {
            stars += (i < score) ? "⭐" : "☆";
        }
        ((TextView)findViewById(R.id.resultRatingText)).setText(stars);

        userData.totalScore += score;
        userData.quizzesCompleted++;
        userData.rating = (float) userData.totalScore / userData.quizzesCompleted;
        saveUserData();
        updateUserStatsViews();
        updateLeaderboard();
    }

    private void updateLeaderboard() {
        boolean playerExists = false;
        for (Player p : leaderboard) {
            if ("You".equals(p.name)) {
                p.score = userData.totalScore;
                p.quizzes = userData.quizzesCompleted;
                p.rating = userData.rating;
                playerExists = true;
                break;
            }
        }

        if (!playerExists) {
            leaderboard.add(new Player("You", userData.totalScore, userData.quizzesCompleted, userData.rating));
        }

        Collections.sort(leaderboard, (p1, p2) -> p2.score - p1.score);
        saveLeaderboard();
    }

    public void goHome(View view) {
        showScreen("home");
    }

    private void showScreen(String screen) {
        homeScreen.setVisibility(View.GONE);
        quizScreen.setVisibility(View.GONE);
        resultScreen.setVisibility(View.GONE);
        leaderboardScreen.setVisibility(View.GONE);

        navHomeLabel.setTextColor(Color.parseColor("#94a3b8"));
        navLeaderboardLabel.setTextColor(Color.parseColor("#94a3b8"));

        if ("home".equals(screen)) {
            homeScreen.setVisibility(View.VISIBLE);
            navHomeLabel.setTextColor(Color.parseColor("#FACC15"));
        } else if ("quiz".equals(screen)) {
            quizScreen.setVisibility(View.VISIBLE);
        } else if ("result".equals(screen)) {
            resultScreen.setVisibility(View.VISIBLE);
        } else if ("leaderboard".equals(screen)) {
            leaderboardScreen.setVisibility(View.VISIBLE);
            navLeaderboardLabel.setTextColor(Color.parseColor("#FACC15"));
            showLeaderboard();
        }
    }

    private void showLeaderboard() {
        leaderboardList.setAdapter(new LeaderboardAdapter(leaderboard));
    }

    // Inner Classes
    static class Category {
        String id, name, icon, color;
        Category(String id, String name, String icon, String color) {
            this.id = id; this.name = name; this.icon = icon; this.color = color;
        }
    }

    static class Question {
        String question;
        String[] options;
        int correctIndex;
        Question(String question, String[] options, int correctIndex) {
            this.question = question; this.options = options; this.correctIndex = correctIndex;
        }
    }

    static class Player {
        String name;
        int score, quizzes;
        float rating;
        Player(String name, int score, int quizzes, float rating) {
            this.name = name; this.score = score; this.quizzes = quizzes; this.rating = rating;
        }
    }

    static class UserData {
        int totalScore = 0;
        int quizzesCompleted = 0;
        float rating = 0.0f;
    }

    // Leaderboard Adapter
    class LeaderboardAdapter extends RecyclerView.Adapter<LeaderboardAdapter.ViewHolder> {
        private List<Player> players;
        LeaderboardAdapter(List<Player> players) { this.players = players; }

        @NonNull
        @Override
        public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
            View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_leaderboard, parent, false);
            return new ViewHolder(view);
        }

        @Override
        public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
            Player p = players.get(position);
            holder.rank.setText(String.valueOf(position + 1));
            holder.name.setText(p.name);
            String stars = "";
            for (int i=0; i<5; i++) stars += (i < Math.round(p.rating)) ? "⭐" : "☆";
            holder.stats.setText(stars + " • " + p.quizzes + " quizzes");
            holder.score.setText(String.valueOf(p.score));

            if (position == 0) holder.rank.setBackgroundResource(R.drawable.rank_gold_circle);
            else if (position == 1) holder.rank.setBackgroundResource(R.drawable.rank_silver_circle);
            else if (position == 2) holder.rank.setBackgroundResource(R.drawable.rank_bronze_circle);
            else holder.rank.setBackground(null);
        }

        @Override
        public int getItemCount() { return players.size(); }

        class ViewHolder extends RecyclerView.ViewHolder {
            TextView rank, name, stats, score;
            ViewHolder(View v) {
                super(v);
                rank = v.findViewById(R.id.playerRank);
                name = v.findViewById(R.id.playerName);
                stats = v.findViewById(R.id.playerStats);
                score = v.findViewById(R.id.playerScore);
            }
        }
    }

    @Override
    public void onBackPressed() {
        new AlertDialog.Builder(this)
                .setTitle("Exit Application")
                .setMessage("Are you sure you want to exit?")
                .setPositiveButton("Yes", (dialog, which) -> finishAffinity())
                .setNegativeButton("No", null)
                .show();
    }
}
