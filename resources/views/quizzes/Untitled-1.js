$res->result = 0;
auth()
                        ->user()
                        ->results()
                        ->create([
                            'quiz_id' => $quiz->id,
                            'user_id' => auth()->user()->id,
                            'result' => $res->result
                        ]);