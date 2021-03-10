
public class SessionListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_session);
		
		RequestQueue request_queue = Volley.newRequestQueue(SessionListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/session/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][4];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("session_name");
				Items[i][1] = json_object.getString("session_detail");
				Items[i][2] = json_object.getString("start_date");
				Items[i][3] = json_object.getString("end_date");
				
			
								}
								
								SessionAdapter sessionAdapter;
                    			sessionAdapter = new SessionAdapter(SessionListActivity.this,Items);
                    			session_listView.setAdapter(sessionAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(SessionListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(SessionListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 session_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(SessionListActivity.this, SessionView.class);
                i.putExtra("session_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
