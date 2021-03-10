
public class ScholarshipListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_scholarship);
		
		RequestQueue request_queue = Volley.newRequestQueue(ScholarshipListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/scholarship/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][3];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("scholarship_name");
				Items[i][1] = json_object.getString("scholarship_detail");
				Items[i][2] = json_object.getString("scholarship_value");
				
			
								}
								
								ScholarshipAdapter scholarshipAdapter;
                    			scholarshipAdapter = new ScholarshipAdapter(ScholarshipListActivity.this,Items);
                    			scholarship_listView.setAdapter(scholarshipAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(ScholarshipListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(ScholarshipListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 scholarship_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(ScholarshipListActivity.this, ScholarshipView.class);
                i.putExtra("scholarship_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
