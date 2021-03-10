
public class CoursesListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_courses);
		
		RequestQueue request_queue = Volley.newRequestQueue(CoursesListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/courses/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][5];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("class");
				Items[i][1] = json_object.getString("course_name");
				Items[i][2] = json_object.getString("course_detail");
				Items[i][3] = json_object.getString("course_fee");
				Items[i][4] = json_object.getString("is_subject");
				
			
								}
								
								CoursesAdapter coursesAdapter;
                    			coursesAdapter = new CoursesAdapter(CoursesListActivity.this,Items);
                    			courses_listView.setAdapter(coursesAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(CoursesListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(CoursesListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 courses_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(CoursesListActivity.this, CoursesView.class);
                i.putExtra("course_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
