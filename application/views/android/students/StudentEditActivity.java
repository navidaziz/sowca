
public class StudentEditActivity extends AppCompatActivity {
	
	private text student_name;
				private text father_name;
				private EditText gender;
				private text address;
				private text mobile_no;
				private text phone_no;
				private text class;
				private text institute;
				private EditText on_scholarship;
				private EditText scholarship_id;
				private EditText scholarship_value;
				private EditText transport;
				private Button btn_update_students;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.activity_edit_student);
		
		student_name = (text)findViewById(R.id.student_name);
				father_name = (text)findViewById(R.id.father_name);
				gender = (EditText)findViewById(R.id.gender);
				address = (text)findViewById(R.id.address);
				mobile_no = (text)findViewById(R.id.mobile_no);
				phone_no = (text)findViewById(R.id.phone_no);
				class = (text)findViewById(R.id.class);
				institute = (text)findViewById(R.id.institute);
				on_scholarship = (EditText)findViewById(R.id.on_scholarship);
				scholarship_id = (EditText)findViewById(R.id.scholarship_id);
				scholarship_value = (EditText)findViewById(R.id.scholarship_value);
				transport = (EditText)findViewById(R.id.transport);
				btn_edit_students = (Button)findViewById(R.id.btn_update_students);
		
		
		
		Intent intent = getIntent();
		String id = intent.getStringExtra("id");
		
		RequestQueue request_queue = Volley.newRequestQueue(StudentEditActivity.this);
		StringRequest request = new StringRequest(Request.Method.POST, SERVER_URL+"/mobile/student/view_student/"+id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								try {
                    			JSONArray JsonArray = new JSONArray(server_response);
								for(int i=0; i<=JsonArray.length(); i++){
									JSONObject json_object = JsonArray.getJSONObject(i);
									student_name.setText(json_object.getString("student_name"));
				father_name.setText(json_object.getString("father_name"));
				gender.setText(json_object.getString("gender"));
				address.setText(json_object.getString("address"));
				mobile_no.setText(json_object.getString("mobile_no"));
				phone_no.setText(json_object.getString("phone_no"));
				class.setText(json_object.getString("class"));
				institute.setText(json_object.getString("institute"));
				on_scholarship.setText(json_object.getString("on_scholarship"));
				scholarship_id.setText(json_object.getString("scholarship_id"));
				scholarship_value.setText(json_object.getString("scholarship_value"));
				transport.setText(json_object.getString("transport"));
				
			
								}
			
			
							} catch (JSONException e) {
								e.printStackTrace();
							 //   Toast.makeText(MainActivity.this, "error", Toast.LENGTH_SHORT).show();
							}
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(StudentAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									return params;
								}
							};
							
				 request_queue.add(request);



	
btn_update_students.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
              final String form_student_name = student_name.getText().toString();
				final String form_father_name = father_name.getText().toString();
				final String form_gender = gender.getText().toString();
				final String form_address = address.getText().toString();
				final String form_mobile_no = mobile_no.getText().toString();
				final String form_phone_no = phone_no.getText().toString();
				final String form_class = class.getText().toString();
				final String form_institute = institute.getText().toString();
				final String form_on_scholarship = on_scholarship.getText().toString();
				final String form_scholarship_id = scholarship_id.getText().toString();
				final String form_scholarship_value = scholarship_value.getText().toString();
				final String form_transport = transport.getText().toString();
				
				
				RequestQueue request_queue = Volley.newRequestQueue(StudentAddActivity.this); 
				 StringRequest request = new StringRequest(Request.Method.POST, url+"/mobile/student/save_data/"+form_student_id, new Response.Listener<String>() {
								@Override
								public void onResponse(String server_response) {
								Toast.makeText(StudentAddActivity.this, server_response, Toast.LENGTH_SHORT).show();
								}
							}, new Response.ErrorListener() {
								@Override
								public void onErrorResponse(VolleyError volleyError) {
								Toast.makeText(StudentAddActivity.this, volleyError.toString(), Toast.LENGTH_SHORT).show();
								}
							}){
								@Override
								protected Map<String, String> getParams()  {
									HashMap<String,String> params = new HashMap<String,String>();
									params.put("student_name", form_student_name);
				params.put("father_name", form_father_name);
				params.put("gender", form_gender);
				params.put("address", form_address);
				params.put("mobile_no", form_mobile_no);
				params.put("phone_no", form_phone_no);
				params.put("class", form_class);
				params.put("institute", form_institute);
				params.put("on_scholarship", form_on_scholarship);
				params.put("scholarship_id", form_scholarship_id);
				params.put("scholarship_value", form_scholarship_value);
				params.put("transport", form_transport);
				
									return params;
								}
							};
							
				 request_queue.add(request);
				
				
            }
        });
//end here .....
		
		
        
    }

}
