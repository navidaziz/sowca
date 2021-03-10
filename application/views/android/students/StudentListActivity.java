
public class StudentListActivity extends AppCompatActivity {
	
	static String[][] Items;
    private GoogleApiClient client;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_list_student);
		
		RequestQueue request_queue = Volley.newRequestQueue(StudentListActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/student/view", new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								 Items = new String[JsonArray.length()][12];
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									Items[i][0] = json_object.getString("student_name");
				Items[i][1] = json_object.getString("father_name");
				Items[i][2] = json_object.getString("gender");
				Items[i][3] = json_object.getString("address");
				Items[i][4] = json_object.getString("mobile_no");
				Items[i][5] = json_object.getString("phone_no");
				Items[i][6] = json_object.getString("class");
				Items[i][7] = json_object.getString("institute");
				Items[i][8] = json_object.getString("on_scholarship");
				Items[i][9] = json_object.getString("scholarship_id");
				Items[i][10] = json_object.getString("scholarship_value");
				Items[i][11] = json_object.getString("transport");
				
			
								}
								
								StudentAdapter studentAdapter;
                    			studentAdapter = new StudentAdapter(StudentListActivity.this,Items);
                    			student_listView.setAdapter(studentAdapter);
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							    Toast.makeText(StudentListActivity, "Error in Json", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(StudentListActivity, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);
		
		
		
 student_listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent i = new Intent(StudentListActivity.this, StudentView.class);
                i.putExtra("student_id", Items[position][0]);
                startActivity(i);
            }
        });
		
		

        
    }

}
